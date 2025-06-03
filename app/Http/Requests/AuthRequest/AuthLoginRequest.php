<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
            "email"=>[
                "required",
                "min:8",
                "max:150",
                "exists:users"
            ],
            "password" => [
                "required",
                "min:8",
                "max:30",
            ],
        ];
    }

    public function messages()
    {
        return [
            "email.required"=>"Email alanının girilmesi zorunludur!",
            "email.min"=>"Email alanına minimum 8 karakter girilebilir!",
            "email.max"=>"Email alanına maksimum 150 karakter girilebilir!",
            "email.exists"=>"Girilen e-mail veya şifre hatalıdır!",
            "password.required"=>"Şifre alanının girilmesi zorunludur!",
            "password.min"=>"Şifre alanına minimum 8 karakter girilebilir!",
            "password.max"=>"Şifre alanına maksimum 30 karakter girilebilir!",
        ];
    }
}
