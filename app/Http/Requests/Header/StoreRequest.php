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
            'company'            =>  'required|string|min:3|max:100',
            'property'           =>  'required|string|min:3|max:100',
            'position'           =>  'required|string|min:3|max:100',
            'approver'           =>  'required|string|min:3|max:100',
            'card'               =>  'required|numeric|min:3|max:70',
            'created_date'       =>  'required',
            'dish'               =>  'required|string|min:3|max:80',
            'dev'                =>  'required|string|min:3|max:100',
            'approver2'          =>  'required|string|min:3|max:100',
            'approver2_position' =>  'required|string|min:3|max:100',
        ];
    }
    public function messages()
    {
        return [
            'required'  => 'Поле обязательно для заполнения.',
            'unique'    => 'Такое значение поля уже существует.',
            'int'       => 'Поле должно содержать только числа',
            'between'     => 'Количество символов должно быть в пределах 3-100.',
            'max'   => 'Поле не должно превышать 100 символов.',
        ];
    }
}
