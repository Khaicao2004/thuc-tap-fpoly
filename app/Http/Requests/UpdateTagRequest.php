<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags')->ignore($this->tag->id)
                ],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên tag là bắt buộc.',
            'name.unique' => 'Tên tag đã tồn tại.',
            'name.max' => 'Tên tag không được vượt quá 255 ký tự.',
        ];
    }
}
