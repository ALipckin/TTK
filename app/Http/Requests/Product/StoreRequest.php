<?php

namespace App\Http\Requests\Product;

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
            'name' => 'required|min:3|max:20',
            'protein'      =>  'required |numeric | max:30', 
            'carbs'       =>  'required | numeric | max:30',
            'fat'         =>  'required | numeric| max:30' ,
            'water'         =>  'required | numeric | max:30',
            'fiber'        =>  'required | numeric | max:30',
            'ash'           =>  'required | numeric | max:30',
            'category_id'           =>  'required | max:30',
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
