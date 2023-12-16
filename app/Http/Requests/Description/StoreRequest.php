<?php

namespace App\Http\Requests\Description;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
            'required'  => 'Поле обязательно для заполнения.',
            'min'         => 'Поле должно содержать минимум 3 символа',
            'max'   => 'Поле не должно превышать 100 символов.',
        ];
    }
}
