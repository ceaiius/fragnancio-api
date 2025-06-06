<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCredentialsRequest extends FormRequest
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
            'username' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['sometimes', 'string', 'email', Rule::unique('users')->ignore(auth()->id())],
            'password' => ['sometimes', 'string', 'min:6'],
            'current_password' => ['required_with:password', 'string', 'current_password'],
        ];
    }
} 