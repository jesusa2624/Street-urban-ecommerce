<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'docType' => 'required|in:DNI,RUC',
            'docNumber' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[0-9]{9}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'docType.required' => 'El tipo de documento es requerido.',
            'docType.in' => 'El tipo de documento debe ser DNI o RUC.',
            'docNumber.required' => 'El número de documento es requerido.',
            'docNumber.string' => 'El número de documento debe ser texto.',
            'docNumber.max' => 'El número de documento no puede exceder 20 caracteres.',
            'name.required' => 'El nombre es requerido.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.max' => 'El correo no puede exceder 255 caracteres.',
            'phone.required' => 'El teléfono es requerido.',
            'phone.regex' => 'El teléfono debe ser un número de 9 dígitos.',
        ];
    }
}
