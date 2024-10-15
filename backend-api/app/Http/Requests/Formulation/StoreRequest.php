<?php

namespace App\Http\Requests\Formulation;

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
            'brutto' => 'required|numeric',
            'netto' => 'required|numeric',
            "product_id" => 'required',
            "package_id" => 'required',
            "heat_treatments" => '',
            "initial_treatments" => '',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'numeric' => 'Поле должно содержать только числа.',
            'digits_between' => 'Поле должно содержать от :min до :max цифр.',
            'date' => 'Поле должно быть действительной датой.',
        ];
    }
}
