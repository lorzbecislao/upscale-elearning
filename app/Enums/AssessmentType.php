<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self Quiz()
 * @method static self Coding()
 */
class AssessmentType extends Enum
{
    protected static function values(): array
    {
        return [
            'Quiz' => 1,
            'Coding' => 2,
        ];
    }
}
