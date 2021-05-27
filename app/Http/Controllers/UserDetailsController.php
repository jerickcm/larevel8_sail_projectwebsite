<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;

class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::findorFail(1);

        $address = new UserDetails(['street'=>'test']);

        $user->userdetails()->save($address);

        $UserDetails = UserDetails::findorFail(1);

        dd($UserDetails->street);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $UserDetails = UserDetails::whereUserId(1)->first();

        $UserDetails->street = 'test';

        $UserDetails->save();

        $UserDetails = UserDetails::whereUserId(1)->first();

        dd($UserDetails);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        echo $id;
        $user = User::findOrFail($id);
        $user->userdetails()->delete();
        // $user =  \App\Models\User::findorFail($id);
        // $user->delete();
        dd($user);


        // $user->userdetails()->delete();
        // $user = User::findOrFail($id);
        // dd($user);
    }
}