<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogController extends FormRequest
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
            'name' => 'required|string|min:20|max:100',
            'image' => 'required|image|mimes:png,jpg,webp|max:2048', // 2048 KB = 2 MB
            'content' => 'required|string|min:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.min' => 'Tên phải có ít nhất 20 ký tự.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',

            'image.required' => 'Trường hình ảnh là bắt buộc.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: png, jpg, hoặc webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',

            'content.required' => 'Trường nội dung là bắt buộc.',
            'content.string' => 'Nội dung phải là một chuỗi ký tự.',
            'content.min' => 'Nội dung phải có ít nhất 100 ký tự.',
        ];
    }
}
