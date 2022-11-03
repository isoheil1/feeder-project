<?php

namespace App\Http\Requests;

use App\Enums\ProductAvailability;
use App\Enums\ProductCondition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'sku' => 'required|string|unique:products',
            'image_link' => 'required|url',
            'availability' => ['required', new Enum(ProductAvailability::class)],
            'availability_date' => 'required|date',
            'condition' => ['required', new Enum(ProductCondition::class)],
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'sale_price' => 'numeric',
        ];
    }
}
