<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|min:6',
            'value' => 'required|string|email',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Пароль является обязательным полем для заполнения',
            'password.regex' => 'Пароль может содержать от 3 заглавных или прописных букв, цифру и специальный символ',
            'value.required' => 'Почтовый адрес является обязательным полем для заполнения',
            'value.string' => 'Почтовый адрес должен быть строкой',
            'value.email' => 'Почтовый адрес должен быть заполнен в правильном формате',
        ];
    }
}
