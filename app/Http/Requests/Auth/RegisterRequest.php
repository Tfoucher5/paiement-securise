<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed', // Validation pour confirmer le mot de passe
                'min:8', // Minimum 8 caractères
                'regex:/[A-Z]/', // Au moins une majuscule
                'regex:/[a-z]/', // Au moins une minuscule
                'regex:/[0-9]/', // Au moins un chiffre
                'regex:/[@$!%*?&.-_]/', // Au moins un caractère spécial
            ],
        ];
    }

    /**
     * Customizes the error messages for password validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ];
    }
}
