<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'      => 'required|string|unique:users,phone',
            // 'phone' => [ 'required', 'regex:/^[6-9]\d{9}$/', 'unique:users,phone'],
            'email'      => 'required|email|unique:users,email',
            'farm_name'  => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'phone.regex' => 'Please enter a valid phone number (10 digits, starting with 6-9).',
            'phone.unique'        => 'This phone number is already taken.',
            'email.required'      => 'Email is required.',
            'email.email'         => 'Please provide a valid email address.',
            'email.unique'        => 'This email is already registered.',
            'farm_name.required'  => 'Farm name is required.',
              'referral_code' =>''
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => 'error',
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422));
    }

}
