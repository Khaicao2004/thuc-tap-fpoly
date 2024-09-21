<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'catalogue_id' => ['required', Rule::exists('catalogues', 'id')],
            'name' => 'required|max:255',
            'sku' => 'required|max:255|unique:products',
            'img_thumbnail' => 'image|required',
            'price_regular' => 'required|numeric|min:0',
            'price_sale' => 'required|numeric|min:0',

            'description' => 'max:255',
            'content' => 'max:65000',
            'material' => 'max:255',
            'user_manual' => 'max:255',

            'product_variants' => 'required|array',
            'product_variants.*.quantity' => 'required|integer|min:0',
            'product_variants.*.price' => 'required|numeric|min:0',

            'tags' => 'array',
            'tags.*' => ['required', 'integer', Rule::exists('tags', 'id')],

            'product_galleries' => 'array',
            'product_galleries.*' => 'image',
        ];
    }

    public function messages(): array
    {
        return [
            'product_variants.*.price.min' => 'Giá bán của biến thể không được nhỏ hơn giá nhập của sản phẩm.',
            'price_regular.min' => 'Giá nhập không được nhỏ hơn 0.',
            'price_sale.min' => 'Giá bán không được nhỏ hơn 0.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $priceRegular = $this->input('price_regular');
            $priceSale = $this->input('price_sale');

            // Kiểm tra giá bán không nhỏ hơn giá nhập
            if ($priceSale < $priceRegular) {
                $validator->errors()->add('price_sale', 'Giá bán không được nhỏ hơn giá nhập.');
            }

            // Kiểm tra giá từng biến thể
            if ($this->input('product_variants')) {
                foreach ($this->input('product_variants') as $variant) {
                    if (isset($variant['price']) && $variant['price'] < $priceRegular) {
                        $validator->errors()->add('product_variants.*.price', 'Giá bán của biến thể không được nhỏ hơn giá nhập của sản phẩm.');
                        break; // Chỉ cần thêm thông báo một lần
                    }
                }
            }
        });
    }
}
