<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pasif()
 * @method static static Aktif()
 * @method static static Beklemede()
 */
final class ServiceType extends Enum
{
    const Pasif =   0;
    const Aktif =   1;
    const Beklemede = 2;

    public static function parseDatabase($value)
    {
        return (int) $value;
    }
}

