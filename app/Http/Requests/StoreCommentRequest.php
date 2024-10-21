<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'content' => 'required|max:500',
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function messages(): array
{
    return [
        'content.required' => 'Vui lòng nhập nội dung bình luận.',
        'content.max' => 'Nội dung bình luận không được vượt quá :max ký tự.',
        'product_id.required' => 'Mua sản phẩm mới được bình luận.',
        'product_id.exists' => 'Sản phẩm bạn chọn không hợp lệ.',
    ];
}
}
