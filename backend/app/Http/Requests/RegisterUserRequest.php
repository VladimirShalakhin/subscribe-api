<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'password' => 'required|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|min:6',
            'value' => 'required|email|unique:emails',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя является обязательным полем для заполнения',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Максимальная длина имени равна 255 символам',
            'password.required' => 'Пароль является обязательным полем для заполнения',
            'password.regex' => 'Пароль может содержать от 3 заглавных или прописных букв, цифру и специальный символ',
            'value.required' => 'Почтовый адрес является обязательным полем для заполнения',
            'value.email' => 'Почтовый адрес должен быть заполнен в правильном формате',
            'value.unique' => 'Данный почтовый адрес уже зарегистрирован в системе',
        ];
    }
}
