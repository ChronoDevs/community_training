<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self LATEST()
 * @method static self TOP()
 * @method static self MOST_USED_TAG()
 */
class ListingSort extends Enum
{
    const LATEST = 'latest';
    const TOP = 'top';
    const MOST_USED_TAG = 'most_used_tag';

    public static function TOP_TAGS_LIMIT(): int
    {
        return 10;
    }
}
