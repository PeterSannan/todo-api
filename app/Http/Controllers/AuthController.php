<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['logout']]); // we can access logout api only if user is anthenticated
    }


    public function login(Request $request)
    {
        //validate incoming request 
        $this->loginValidate($request);

        //check the credentials
        $token = $this->attempt($request->input('email'), $request->input('password'));

        //check if username and password are correct, if no format error and send it with status code 401
        if (!$token) {
             $this->sendErrorResponse('Unauthorized', 401, 'Email or Password is incorrect');
             return;
        }

        // if everything was fine send the user information with token
        return new UserResource(Auth::user(), $token);
    }



    public function register(Request $request)
    {
        //validate incoming request
        $this->registerValidate($request);

        try {
            //hash the password
            $plainPassword = $request->input('password');
            $request['password'] = app('hash')->make($plainPassword);

            //create user
            $user = User::create($request->except('password_confirmation'));

            //get the token
            $token = $this->attempt($user->email, $plainPassword);

            //return successful response
            return new UserResource($user, $token);
        } catch (\Exception $e) {
            //return error message if any error occured
            return $this->sendErrorResponse('Unauthorized', 401, 'User Registration Failed!');
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();
    }


    //check if the email and password are correct
    public function attempt($email, $password)
    {
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        $token = Auth::attempt($credentials);
        return $token;
    }

    //validation for register
    public function registerValidate($request)
    {
        //validate incoming request 
        $this->validate($request, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'mobile' => 'required|numeric',
            'gender' => ['required', 'regex:(F|M)'],
            'birthday' => 'required|date_format:Y-m-d',
        ]);
    }

    //validation for login
    public function loginValidate($request)
    {
        //validate incoming request 
        return  $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
