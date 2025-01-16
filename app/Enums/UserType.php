<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self Admin()
 * @method static self Student()
 */
class UserType extends Enum
{
    protected static function values(): array
    {
        return [
            'Admin' => 1,
            'Student' => 2,
        ];
    }
}
