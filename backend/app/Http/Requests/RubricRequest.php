<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RubricRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rubric_id' => 'required|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
