<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sku',
        'image_link',
        'availability',
        'availability_date',
        'condition',
        'brand',
        'price',
        'sale_price'
    ];
}
