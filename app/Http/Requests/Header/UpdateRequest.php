<?php

namespace App\Http\Requests\TTK\Header;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'min:3'     => 'Поле должно содержать не менее 3 символов.',
            'max:100'   => 'Поле не должно превышать 100 символов.',
        ];
    }
}
