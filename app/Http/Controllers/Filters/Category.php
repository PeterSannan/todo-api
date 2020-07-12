<?php
namespace App\Http\Controllers\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Category implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('category_id', $value);
    }
}
