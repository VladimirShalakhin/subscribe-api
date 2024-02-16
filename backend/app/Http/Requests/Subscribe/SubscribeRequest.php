<?php

namespace App\Http\Requests\Subscribe;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
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
            'email' => 'required|email',
            'rubric_ids' => 'required|array',
            'rubric_ids.*' => 'exists:rubrics,id',
        ];
    }

    //не выводится правило при ошибке
    public function messages(): array
    {
        return [
            'rubric_ids.*.exists' => 'Указанный идентификатор рубрики не существует',
        ];
    }
}
