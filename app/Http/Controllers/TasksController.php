<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TaskResource;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TasksController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // access these function only is user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }


    //get all tasks
    public function index(Request $request)
    {
        try {
            
            //taskSearch will check the filters avaialable in the request and check if there is a dedicated class for this filter
            //we will have a dedicated filter class for every filter we need like 'Category' , 'Day' , 'Month',...
            // the advantage of this approach is that everytime we add a new filter , we need just to add new filter class in the filters folder.

            $tasks = TaskSearch::apply($request);
            return  TaskResource::collection($tasks);

        } catch (Exception $e) {
            return $this->sendErrorResponse('Invalid data', 422, 'The given data is invalid');
        }
    }
}
