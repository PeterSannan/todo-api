<?php
namespace App\Http\Controllers\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Status implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('status', $value);
    }
}
