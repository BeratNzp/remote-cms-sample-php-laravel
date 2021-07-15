<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static False()
 * @method static static True()
 */
final class BooleanEnum extends Enum implements LocalizedEnum
{
    const False =   0;
    const True =   1;

    public static function parseDatabase($value)
    {
        return (int) $value;
    }
}
