<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Authorize this request for the authenticated user.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'birthday' => [
                'nullable', 
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Must be 18 or older
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $birthday = Carbon::parse($value);
                        $age = $birthday->age;
                        
                        if ($age < 18) {
                            $fail('You must be at least 18 years old. Your age would be: ' . $age);
                        }
                    }
                },
            ],
            'age' => ['sometimes', 'nullable', 'integer'],
            'gender' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ];
    }
}
