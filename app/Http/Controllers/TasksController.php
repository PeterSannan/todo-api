<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TaskResource;
use App\Task;
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

    //create task
    public function store(Request $request)
    {
        $attributes = $this->createTaskValidate($request);

        //check if category choosen valid and can be accesible(created by the user who's attempting to create this task)
        $this->checkCategory($attributes['category_id']) ?: exit();

        //format the datetime and create task
        $attributes['datetime'] = Carbon::parse($attributes['datetime']);
        $task = Auth::user()->tasks()->create($attributes);
        return  new TaskResource($task);
    }


    //check if user is aauthotized to delete a category if yes deleted or throw a 403 error
    public function destroy(String $task)
    {
        $task = $this->checkTask($task); 
        $task ?: exit();
        $task->delete();
      
    }


    //check if user is aauthotized to delete a category if yes deleted or throw a 403 error
    public function update(Request $request , String $task)
    {
        $attributes = $this->updateTaskValidate($request);
        
        $task = $this->checkTask($task); 
        $task ?: exit();
        //format the datetime and create task
        $attributes['datetime'] = Carbon::parse($attributes['datetime']);

        if($request->has('category_id')){
             $this->checkCategory($attributes['category_id']) ?: exit();
        }

        $task_updated = tap($task)->update($attributes); 
        return  new TaskResource($task_updated);
        
    }

     //validation for updating task
     public function updateTaskValidate($request)
     {
         //validate incoming request 
         return $this->validate($request, [
             'name' => 'string',
             'description' => 'string',
             'status' => ['regex:(1|2|3)'],
             'category_id' => 'numeric',
             'datetime' => 'date_format:d-m-Y H:i',
         ]);
     }


    //validation for creating task
    public function createTaskValidate($request)
    {
        //validate incoming request 
        return $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string',
            'status' => ['required', 'regex:(1|2|3)'],
            'category_id' => 'required',
            'datetime' => 'required|date_format:d-m-Y H:i',
        ]);
    }
}
