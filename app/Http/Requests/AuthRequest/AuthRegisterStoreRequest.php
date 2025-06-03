<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => [
                "required",
                "min:3",
                "max:120",
            ],
            "email"=>[
                "required",
                "min:8",
                "max:150",
                "unique:users"
            ],
            "password" => [
                "required",
                "min:8",
                "max:30",
                "confirmed",
            ],
        ];
    }

    public function messages()
    {
        return [
            "name.required"=>"İsim alanının girilmesi zorunludur!",
            "name.min"=>"İsim alanına minimum 3 karakter girilebilir!",
            "name.max"=>"İsim alanına maksimum 120 karakter girilebilir!",
            "email.required"=>"Email alanının girilmesi zorunludur!",
            "email.min"=>"Email alanına minimum 8 karakter girilebilir!",
            "email.max"=>"Email alanına maksimum 150 karakter girilebilir!",
            "email.unique"=>"Girilen email sistemde mevcuttur!",
            "password.required"=>"Şifre alanının girilmesi zorunludur!",
            "password.min"=>"Şifre alanına minimum 8 karakter girilebilir!",
            "password.max"=>"Şifre alanına maksimum 30 karakter girilebilir!",
            "password.confirmed"=>"Girilen şifreler birbiriyle aynı değildir!",
        ];
    }
}
