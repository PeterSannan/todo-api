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

        //get the credentials
        $credentials = $request->only(['email', 'password']);

        //check if username and password are correct, if no format error and send it with status code 401
        if (!$token = Auth::attempt($credentials)) {
          return  (new ErrorResource((object)[
                'title'=>'Unauthorized',
                'code'=>'401',
                'details'=>'Email or Password is incorrect'
            ]))
            ->response()
            ->setStatusCode(401);
        }

        // if everything was fine send the user information with token
        return new UserResource(Auth::user(), $token);
    }



    public function register(Request $request)
    {
        //validate incoming request
        $this->registerValidate($request);

        try {
            //create new user, we can use mass assignement but for security reasons better to use this approach
            $user = new User();
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->gender = $request->input('gender');
            $user->mobile = $request->input('mobile');
            $user->birthday = $request->input('birthday');
            $user->save();


            $credentials = [
                'email' => $user->email,
                'password' => $plainPassword
            ];

            //get token
            $token = Auth::attempt($credentials);

            //return successful response
            return new UserResource($user, $token);
        } catch (\Exception $e) {
            //return error message
            return  (new ErrorResource((object)[
                'title'=>'Unauthorized',
                'code'=>'401',
                'details'=>'User Registration Failed!'
            ]))
            ->response()
            ->setStatusCode(401);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
    }


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

    public function loginValidate($request)
    {
        //validate incoming request 
        return  $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
