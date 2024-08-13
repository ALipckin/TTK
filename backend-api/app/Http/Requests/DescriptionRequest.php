<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescriptionRequest extends FormRequest
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
            'description'            =>  'required|string|min:3|max:100',
            'ttk_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'string' => 'Поле должно быть строкой.',
            'min' => 'Количество символов в поле минимум :min.',
            'max' => 'Количество символов в поле максимум :max.',
        ];
    }
}
