<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\USer;

class RoleController extends Controller
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
    public function create($user_id)
    {
        echo $user_id;

        $user = User::find($user_id);

        $user->roles()->save(new Role(['name'=>'Visitor']));

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
    public function show($user_id)
    {
        $user = User::find($user_id);

        foreach($user->roles as $role){

            echo $role->name.'<br/>';

        }
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
    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        if($user->has('roles')){
            foreach($user->roles as $role){

                if($role->name =='Visitor'){

                    $role->name  = 'Visitor Inspector';

                    $role->save();

                }

            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id,$role_id)
    {
        $user = User::find($user_id);

        if($user->has('roles')){

            foreach($user->roles as $role){

              $role->whereId($role_id)->delete();

            }
        }
    }


    public function detachall($user_id)
    {
        $user = User::find($user_id);
        $user->roles()->detach();


    }

    public function detach($user_id,$role_id)
    {
        $user = User::find($user_id);
        $user->roles()->detach([$role_id]);
        // $user->roles()->detach([$role_id]);
    }

    public function attach($user_id,$role_id)
    {
        $user = User::find($user_id);
        $user->roles()->attach([$role_id]);
    }

    public function attach_array(Request $request){
        $user = User::find(1);
        $user->roles()->attach([1,5]);
    }

}
