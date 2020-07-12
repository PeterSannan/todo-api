<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class TaskSearch
{

    public static function apply(Request $filters)
    {
        $query = 
            static::applyDecoratorsFromRequest(
                $filters, Auth::user()->tasks()->getQuery()
            );

        return static::getResults($query);
    }
    
    // for each filter available in the request we will check if there is a filter class for it, if yes we will class the apply function of this class
    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }
    
    // adding the full path where we put all our filters
    private static function createFilterDecorator($name)
    {
        return  __NAMESPACE__ . '\\Filters\\' . 
            str_replace(' ', '', 
                ucwords(str_replace('_', ' ', $name)));
    }
    
    //check if the filter class exist
    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private static function getResults(Builder $query)
    {
        return $query->get();
    }

}
