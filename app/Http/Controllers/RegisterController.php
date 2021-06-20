<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Socials;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $time_start = microtime(true);

        // $user = User::where('email',$email);
        // dd($user);
        $user = User::where('email', $request->email)->first();

        if (!$user) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('!Password08'),
            ]);

            UserDetails::create([
                'user_id' => $user->id
            ]);

            Socials::create([
                'user_id' => $user->id,
                'name' => $request->social,
                'social_id' => $request->id
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!Socials::where('name', $request->social)->first()) {
            Socials::create([
                'user_id' => $user->id,
                'name' => $request->social,
                'social_id' => $request->id
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'user' => $request->user(),
            'success' => true,
            'data' => $user,
            '_elapsed_time' => $timeend,
        ], 200);
    }
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

        $address = new UserDetails(['user_id' => $user->id]);

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
