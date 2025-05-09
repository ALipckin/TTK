<?php

namespace App\Http\Requests\Header;

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
            'company' => 'required|string|min:3|max:100',
            'property' => 'required|string|min:3|max:100',
            'position' => 'required|string|min:3|max:100',
            'approver' => 'required|string|min:3|max:100',
            'card' => 'required|integer|digits_between:1,50',
            'created_date' => 'required|date',
            'dish' => 'required|string|min:3|max:80',
            'dev' => 'required|string|min:3|max:100',
            'approver2' => 'required|string|min:3|max:100',
            'approver2_position' => 'required|string|min:3|max:100',
            "ttk_id" => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'string' => 'Поле должно быть строкой.',
            'min' => 'Количество символов в поле минимум :min.',
            'max' => 'Количество символов в поле максимум :max.',
            'integer' => 'Поле должно содержать только целочисленные значения.',
            'digits_between' => 'Поле должно содержать от :min до :max цифр.',
            'date' => 'Поле должно быть действительной датой.',
        ];
    }
}
