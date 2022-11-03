<?php

namespace App\Enums;

enum ProductCondition: string
{
    case New = 'new';
    case Refurbished = 'refurbished';
    case Used = 'used';
}
