<?php

namespace App\Http\Controllers\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Day implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        $day = Carbon::parse($value);
        return $builder->whereDate('datetime', $day);
    }
}
