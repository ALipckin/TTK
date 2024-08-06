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
            'card'               =>  'required|integer|digits_between:1,50',
            'created_date'       =>  'required|date',
            'dish'               =>  'required|string|min:3|max:80',
            'dev'                =>  'required|string|min:3|max:100',
            'approver2'          =>  'required|string|min:3|max:100',
            'approver2_position' =>  'required|string|min:3|max:100',
            "ttk_id"    => 'required'
        ];
    }
    public function messages()
    {
        return [
            'required'  => 'Поле обязательно для заполнения.',
            'integer'       => 'Поле должно содержать только целочисленные цифры',
            'date'     => 'Поле должно быть с действительной датой.',
            'max'   => 'Поле не должно превышать 100 символов.',
            'card.digits_between'  =>  'Поле не должно превышать 50 символов.',
        ];
    }
}
