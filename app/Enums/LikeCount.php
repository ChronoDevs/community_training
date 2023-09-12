<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self ZERO()
 * @method static self ONE()
 * @method static self TWO()
 * @method static self MORE_THAN_TWO()
 */
class LikeCount extends Enum
{
    protected static function values(): array
    {
        return [
            'ZERO' => 0,
            'ONE' => 1,
            'TWO' => 2,
            'MORE_THAN_TWO' => 3, // You can adjust this value as needed
        ];
    }
}
