<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resort;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Store step 1 data and redirect to step 2
     */
    public function storeStep1(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^[0-9]{11}$/', 'unique:users,phone'],
            'birthday' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Must be 18 or older
                function ($attribute, $value, $fail) {
                    try {
                        $birthday = Carbon::parse($value);
                        $age = $birthday->age;
                        
                        if ($age < 18) {
                            $fail('You must be at least 18 years old to register. Your age is: ' . $age);
                        }
                    } catch (\Exception $e) {
                        $fail('Invalid date format for birthday.');
                    }
                },
            ],
            'gender' => 'required|string|in:male,female,other',
            'address' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
        ], [
            'birthday.before_or_equal' => 'You must be at least 18 years old to register.',
            'phone.regex' => 'The number is not enough. Please enter exactly 11 digits.',
        ]);

        $step1Data = $request->only([
            'first_name','middle_name','last_name','phone','birthday','gender','address','nationality'
        ]);
        
        Session::put('register_step1', $step1Data);
        
        // Debug: Log step 1 data storage
        Log::info('Step 1 data stored in session: ', $step1Data);

        return redirect()->route('register.step2');
    }

    /**
     * Show step 2 view
     */
    public function showStep2(): View|RedirectResponse
    {
        if (!Session::has('register_step1')) {
            return redirect()->route('register');
        }
        return view('auth.register2');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Logout any existing user before creating a new one
        if (Auth::check()) {
            Auth::logout();
        }

        // Step 2 validations only
        $validationRules = [
            'username' => 'required|string|max:255|unique:users,username',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|string|in:tourist,resort_owner,boat_owner',
        ];

        // Tourist profile image is optional; validate only when file is present
        if ($request->hasFile('owner_image')) {
            $validationRules['owner_image'] = 'nullable|file|mimes:jpg,jpeg,png|max:2048';
        }

        $request->validate($validationRules);

        try {
            // Debug: Log the request data
            Log::info('Registration request data: ', $request->all());
            
            // Merge step 1 data from session with step 2 inputs
            $step1 = Session::get('register_step1');
            Log::info('Step 1 data from session: ', $step1);
            
            if (!$step1) {
                Log::error('No step 1 data found in session');
                return redirect()->route('register');
            }

            $fullName = trim($step1['first_name'].' '.(($step1['middle_name'] ?? '') ? ($step1['middle_name'].' ') : '').$step1['last_name']);

            $isApproved = ($request->role === 'tourist');

            $userData = [
                'first_name' => $step1['first_name'] ?? null,
                'middle_name' => $step1['middle_name'] ?? null,
                'last_name' => $step1['last_name'] ?? null,
                'username' => $request->username,
                'phone' => $step1['phone'],
                'password' => Hash::make($request->password),
                'birthday' => $step1['birthday'],
                'gender' => $step1['gender'],
                'nationality' => $step1['nationality'],
                'address' => $step1['address'],
                'role' => $request->role,
                'is_approved' => $isApproved,
            ];

            // Generate a 6-digit OTP code for phone verification
            $otpCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store OTP in phone_verified_at column temporarily
            $userData['phone_verified_at'] = $otpCode;
            
            // Debug: Log the OTP being generated
            Log::info('Generated OTP for user registration: ' . $otpCode);

            $user = User::create($userData);
            
            // Debug: Log the created user's phone_verified_at value
            Log::info('User created with phone_verified_at: ' . $user->phone_verified_at);
            Log::info('User created successfully with ID: ' . $user->id);

            // If an image was uploaded, save it to public path and store relative path for all user types
            if ($request->hasFile('owner_image')) {
                $file = $request->file('owner_image');
                $rolePrefix = $request->role === 'tourist' ? 'tourist' : ($request->role === 'resort_owner' ? 'resort' : 'boat');
                $filename = $rolePrefix . '_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $destination = public_path('images/profiles');
                if (!is_dir($destination)) {
                    @mkdir($destination, 0775, true);
                }
                $file->move($destination, $filename);
                $user->owner_image_path = 'images/profiles/' . $filename;
                $user->owner_pic_approved = true; // No approval needed for any user type
                $user->save();
            }
            
            // Automatically create a resort if the user is a resort owner
            if ($request->role === 'resort_owner') {
                Resort::create([
                    'user_id' => $user->id,
                    'resort_name' => $request->username, // Use username as resort name
                    'location' => $step1['address'], // Use address as location
                    'contact_number' => $step1['phone'], // Use phone as contact number
                    'status' => 'open', // Default operational status
                    'admin_status' => 'approved', // Set as automatically approved
                    'visit_count' => 0, // Initialize visit count
                ]);
            }
            
            Auth::login($user);

        } catch (\Throwable $e) {
            Log::error("User creation failed in RegisteredUserController: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            dd(
                'Error during user creation:',
                'Message: ' . $e->getMessage(),
                'File: ' . $e->getFile(),
                'Line: ' . $e->getLine(),
                'Request Data:', $request->all(),
                'Trace:', $e->getTraceAsString()
            );
        }

        Session::forget('register_step1');
        event(new Registered($user));

        // Debug: Log before redirect
        Log::info('Redirecting to verification notice for user: ' . $user->id);
        
        // Redirect to phone verification for all users
        return redirect()->route('verification.notice')->with('success', 'Registration successful! Please verify your phone number to continue.');
    }
}

