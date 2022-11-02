<?php

namespace App\Enums;

enum ProductAvailability: string
{
    case InStock = "in_stock";
    case OutOfStock = "out_of_stock";
    case Preorder = "preorder";
    case Backorder = "backorder";
}
