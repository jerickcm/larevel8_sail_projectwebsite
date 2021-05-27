<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

use App\Models\User;
use App\Models\UserDetails;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $time_start = microtime(true);

        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6',]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);


        $userdata = User::findorFail($user->id);

        $address = new UserDetails(['user_id'=>$user->id]);

        $userdata->address()->save($address);


        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'success' => true,
            'data' => $user,
            '_elapsed_time' => $timeend,
        ], 200);

        // $time_start = microtime(true);

        // $validator = $this->validator($request->all());

        // if (!$validator->fails()) {

        //     $user = $this->create($request->all());
        //     $time_end = microtime(true);
        //     $timeend = $time_end - $time_start;
        //     return response()->json([
        //         'success' => true,
        //         'data' => $user,
        //         '_elapsed_time' => $timeend,

        //     ], 200);
        // }
        // $time_end = microtime(true);
        // $timeend = $time_end - $time_start;
        // return response()->json([
        //     'success' => false,
        //     'errors' => $validator->errors(),

        // ], 200);


    }



    public function test(Request $request)
    {
        die();
        $time_start = microtime(true);
        $time_end = microtime(true);
        $timeend = $time_end - $time_start;
        // $request->session()->regenerate();
        return response()->json([
            'success' => true,
            '_elapsed_time' => $timeend,
            // 'errors' => $validator->errors(),
        ], 200);
    }


}
