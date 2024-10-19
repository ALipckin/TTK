<?php

namespace App\Http\Requests\Formulation;

use App\Models\Treatment;
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
            'brutto' => 'required|numeric',
            'netto' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            "treatment_id" => 'nullable|exists:treatments,id',
        ];
    }
    /**
     * Дополнительная логика проверки после стандартной валидации.
     */
    public function withValidator($validator)
    {
        // Добавляем кастомную проверку
        $validator->after(function ($validator) {
            $treatment = Treatment::find($this->treatment_id);
            if ($treatment && $treatment->product_id != $this->product_id) {
                // Добавляем ошибку, если product_id не соответствует
                $validator->errors()->add('product_id', 'Выбранный продукт не имеет выбранную обработку');
            }
        });
    }
    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'numeric' => 'Поле должно содержать только числа.',
            'digits_between' => 'Поле должно содержать от :min до :max цифр.',
            'date' => 'Поле должно быть действительной датой.',
            'exist' => 'В поле должен быть действительный id',
        ];
    }
}
