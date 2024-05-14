<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool{
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array{
        $profile_updateId = $this->route('profile_update');

        $rules = [
            'name' => 'required',
            'password' => 'confirmed|min:6',
            'email' => [
                'required', // Make the email field optional
                'email',  // Allow null values
                Rule::unique('users', 'email')->ignore($profile_updateId),
            ],
        ];

        // Check if it's an edit scenario
        if ($this->isMethod('patch')) {
            $rules['password'] = 'nullable|confirmed|min:6';
        }
        return $rules;
    }

    public function messages(){
        return [
            'email.required' => 'The email address field is required.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}