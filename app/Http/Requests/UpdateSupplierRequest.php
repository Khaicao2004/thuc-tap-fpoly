<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'tax_code' => 'required|max:13',
            'name' => 'required|max:100',
            'address' => 'required|string|max:255',
            'phone' => "required|max:11|unique:suppliers,phone,$id",
            'email' => "required|max:255|unique:suppliers,email,$id",
        ];
    }
    public function messages()
    {
        return [
            'tax_code.required' => 'Bắt buộc nhập',
            'tax_code.max' => 'Quá số lượng ký tự',
            'name.required' => 'Bắt buộc nhập',
            'name.max' => 'Quá số lượng ký tự',
            'address.required' => 'Bắt buộc nhập',
            'address.string' => 'Bắt buộc phải là chuỗi',
            'address.max' => 'Quá số lượng ký tự',
            'phone.required' => 'Bắt buộc nhập',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'phone.max' => 'Quá số lượng ký tự',
            'email' => 'Bắt buộc nhập',
            'email.max' => 'Quá số lượng ký tự',
            'email.unique' => 'Email đã tồn tại',

        ];
    }
}
