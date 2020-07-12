<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use Laravel\Lumen\Routing\Controller as BaseController;

//import auth facades
use Illuminate\Support\Facades\Auth;

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
            ->setStatusCode($code);
    }
}
