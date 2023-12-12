<?php

namespace App\Http\Requests\Product;

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
            'name' => 'required|min:3|max:20',
            'protein'      =>  'required |numeric | ', 
            'carbs'       =>  'required | numeric',
            'fat'         =>  'required | numeric',
            'water'         =>  'required | numeric',
            'fiber'        =>  'required | numeric',
            'ash'           =>  'required | numeric',
            'category_id'           =>  'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'unique' => 'Такое значение поля уже существует.',
            'numeric'       => 'Поле должно содержать только числа',
            'min'         => 'Поле должно содержать минимум 3 символа',
            'max'         => 'Поле должно содержать максимум 20 символов',
            'between'     => 'Количество символов должно быть в пределах 3-100.',
        ];
    }
}
