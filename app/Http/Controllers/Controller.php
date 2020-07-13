<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\ErrorResource;
use App\Task;
use Laravel\Lumen\Routing\Controller as BaseController;

//import auth facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    public function sendErrorResponse($title, $code, $details)
    {
        return (new ErrorResource((object)[
            'title' => $title,
            'code' => $code,
            'details' => $details
        ]))
            ->response()
            ->setStatusCode($code)->send(); 
 
    }

    public function checkCategory($categoryid)
    {
        $category = Category::findOrFail($categoryid);
        if (Gate::denies('manage-category', $category)) {
             $this->sendErrorResponse('Forbidden', 403, 'You cannot access this category');
             return false;
        }else{
            return $category;
        }
    }


    public function checkTask($taskid)
    {
        $task = Task::findOrFail($taskid);
        if (Gate::denies('manage-task', $task)) {
             $this->sendErrorResponse('Forbidden', 403, 'You cannot access this task');
             return false;
        }else{
            return $task;
        }
    }
}
