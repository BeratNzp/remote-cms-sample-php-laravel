<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static Product()
 * @method static static Variant()
 * @method static static Blog()
 */
final class CategoryType extends Enum implements LocalizedEnum
{
    const Product =   1;
    const Variant =   2;
    const Blog = 3;

    public static function parseDatabase($value)
    {
        return (int) $value;
    }
}

