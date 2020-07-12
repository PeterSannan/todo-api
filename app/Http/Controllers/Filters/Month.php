<?php

namespace App\Http\Controllers\Filters;

use Illuminate\Database\Eloquent\Builder;

class Month implements Filter
{
    public static function apply( Builder $builder, $value)
    {
        $date = explode('-',$value);  
        return $builder
            ->whereMonth('datetime',$date[0])
            ->whereYear('datetime',$date[1]); 
    }
}