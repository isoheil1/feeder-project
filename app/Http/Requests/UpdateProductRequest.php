<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'sku' => 'string|unique:products',
            'image_link' => 'url',
            'availability' => [new Enum(ProductAvailability::class)],
            'availability_date' => 'date',
            'condition' => [new Enum(ProductCondition::class)],
            'brand' => 'string',
            'price' => 'numeric',
            'sale_price' => 'numeric',
        ];
    }
}
