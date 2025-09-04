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
                    $birthday = Carbon::parse($value);
                    $age = $birthday->age;
                    
                    if ($age < 18) {
                        $fail('You must be at least 18 years old to register. Your age is: ' . $age);
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

        Session::put('register_step1', $request->only([
            'first_name','middle_name','last_name','phone','birthday','gender','address','nationality'
        ]));

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
            // Merge step 1 data from session with step 2 inputs
            $step1 = Session::get('register_step1');
            if (!$step1) {
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

            $user = User::create($userData);

            // If role is tourist and an image was uploaded, save it to public path and store relative path
            if ($request->role === 'tourist' && $request->hasFile('owner_image')) {
                $file = $request->file('owner_image');
                $filename = 'tourist_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $destination = public_path('images/profiles');
                if (!is_dir($destination)) {
                    @mkdir($destination, 0775, true);
                }
                $file->move($destination, $filename);
                $user->owner_image_path = 'images/profiles/' . $filename;
                $user->owner_pic_approved = true; // Tourists don't need approval
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

        if ($user->role === 'resort_owner') {
            return redirect()->route('resort.owner.dashboard')->with('success', 'Registration successful! Your resort has been automatically approved and is ready to use. Start adding rooms to get started!');
        } elseif ($user->role === 'boat_owner') {
            return redirect()->route('boat.owner.dashboard');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}

