<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->segment(3);
        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id",
            'type' => ['required', 'in:' . User::TYPE_ADMIN . ',' . User::TYPE_MEMBER],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường này là bắt buộc phải được điền',
            'name.string' => 'Giá trị của trường này phải là một chuỗi ký tự',
            'name.max' => 'Giá trị của trường này không được vượt quá 255 ký tự.',

            'email.required' => ' Trường này là bắt buộc phải được điền.',
            'email.email' => ' Trường này phải là email.',
            'email.max' => 'Quá số lượng ký tự',
            'email.unique' => 'Email đã tồn tại',



            'type' => ' Type',


        ];
    }
}
