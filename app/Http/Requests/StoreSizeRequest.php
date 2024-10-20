<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
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
            'name' => 'required|string|max:10|unique:product_sizes,name',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên size là bắt buộc.',
            'name.unique' => 'Tên size đã tồn tại.',
            'name.max' => 'Tên size không được vượt quá 10 ký tự.',
        ];
    }
}
