<?php

namespace App\Http\Requests\TTK;

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
            'name'           =>  'string|min:3|max:45',
            'image'          =>  'image| max:10000',
            'public'           =>  'boolean',
            'isDraft'           =>  'boolean',
        ];
    }
    public function messages()
    {
        return [
            'required'  => 'Поле обязательно для заполнения.',
            'between'   => 'Количество символов должно быть в пределах 3-45.',
            'size'      => 'Максимальный размер 10 Мб'
        ];
    }
}
