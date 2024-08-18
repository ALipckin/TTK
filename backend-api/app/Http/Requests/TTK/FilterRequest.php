<?php

namespace App\Http\Requests\TTK;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'name'          => 'string',
            'category_id'   =>  'numeric',
        ];
    }
    public function messages()
    {
        return [
            'numeric'       => 'Поле должно содержать только числа',
            'string'       => 'Поле должно содержать только строчные символы',
        ];
    }
}
