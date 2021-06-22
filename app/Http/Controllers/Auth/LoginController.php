<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // public function login(Request $request)



        if (!User::where('email', $request->email)->first()) {



            return response()->json([
                'data' => 'email does not exist',
                  '_benchmark' => microtime(true) -  $this->time_start,
            ], 401);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {


            return response()->json([
                'data' => 'Invalid Credentials',
                  '_benchmark' => microtime(true) -  $this->time_start,
            ], 401);
        }

        $request->session()->regenerate();



        return response()->json([
            'success' => true,
              '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }

    // public function logout(Request $request)
    // {
    //

    //     auth()->guard('web')->logout();

    //     $request->session()->invalidate();

    //     // $request->session()->regenerateToken();
    //
    //

    //     // return response()->json(null, 200);


    //     return response()->json([
    //         'success' => true,
    //           '_benchmark' => microtime(true) -  $this->time_start,
    //         // 'errors' => $validator->errors(),
    //     ], 200);
    // }
}
