<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Carbon\Carbon;
// events
use App\Events\UserLogsEvent;

//models
use App\Models\AdminUsersLogs;
use App\Models\User;
use App\Models\UserDetails;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $logs = AdminUsersLogs::where('id', 1)->get();
        foreach ($logs as $key => $value) {
            echo $value;
        }
        // var_dump($logs->description);
        // var_dump($logs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $email)
    {


        $user = User::where('email', $email)->first();
        $user->details = $user->userdetails;


        return response()->json([
            'user' =>  $user,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }

    public function show_username($username)
    {


        $user_details = UserDetails::where('username', $username)->first();
        $user = User::where('id', $user_details->user_id)->first();
        $user->details =  $user_details;


        return response()->json([
            'user' =>   $user,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
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
    public function update(Request $request)
    {

        $UserDetails = UserDetails::where('user_id', $request->user_id)->first();
        $UserDetails->username =  $request->username;
        $UserDetails->save();

        $user = User::where('id', $request->user_id)->first();
        $user->is_admin = $request->is_admin;
        $user->name  = $request->name;
        $user->save();

        event(new UserLogsEvent($request->user()->id, AdminUsersLogs::TYPE_USERS_UPDATE, [
            'admin'  => $request->user()->name,
            'admin_id'  => $request->user()->id,
            'user_id'  => $request->user_id,
            'user_name'  => $request->name,
        ]));

        return response()->json([
            'user' => $request->user(),
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->userdetails()->where('user_id', $request->user_id)->delete();
        $user->delete();
    }
    public function datatable(Request $request)
    {
        $skip = $request->page;
        if ($request->page == 1) {
            $skip = 0;
        } else {
            $skip = $request->page * $request->page;
        }

        if ($request->sortBy == ""  && $request->sortDesc == "") {

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $users = UserDetails::where([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['user_details.username', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'user_details.user_id')
                ->select('users.id', 'users.is_admin', 'users.name', 'users.email', 'users.created_at', 'user_details.username', 'user_details.house_number', 'user_details.street', 'user_details.city', 'user_details.province', 'user_details.country', 'user_details.postcode', 'user_details.username', 'user_details.profile_picture', 'user_details.cover_photo')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $users_count = UserDetails::where([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['user_details.username', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'user_details.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $users = UserDetails::where([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['user_details.username', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'user_details.user_id')
                ->select('users.id', 'users.is_admin', 'users.name', 'users.email', 'users.created_at', 'user_details.username', 'user_details.house_number', 'user_details.street', 'user_details.city', 'user_details.province', 'user_details.country', 'user_details.postcode', 'user_details.username', 'user_details.profile_picture', 'user_details.cover_photo')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $users_count = UserDetails::where([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['user_details.username', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'user_details.user_id')
                ->get();
        }

        $usersCs =   $users->count();
        $usersCount =  $users_count->count();

        foreach ($users as $key => $value) {
            $users[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }


        if ($usersCs > 0 && $usersCount == 0) {
            $usersCount =   $usersCs;
        }

        return response()->json([
            'data' => $users,
            'total' =>  $usersCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }


    public function datatable_logs(Request $request)
    {
        $skip = $request->page;
        if ($request->page == 1) {
            $skip = 0;
        } else {
            $skip = $request->page * $request->page;
        }

        if ($request->sortBy == ""  && $request->sortDesc == "") {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $users = AdminUsersLogs::where([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'admin_users_logs.user_id')
                ->select('users.id', 'users.is_admin', 'users.name', 'users.email', 'admin_users_logs.*')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $users_count = AdminUsersLogs::where([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'admin_users_logs.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $users = AdminUsersLogs::where([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'admin_users_logs.user_id')
                ->select('users.id', 'users.is_admin', 'users.name', 'users.email', 'users.created_at', 'admin_users_logs.*')
                ->orderBy('admin_users_logs.' . $request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();


            $users_count = AdminUsersLogs::where([['users.email', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'admin_users_logs.user_id')
                ->get();
        }

        $usersCs =   $users->count();
        $usersCount =  $users_count->count();

        foreach ($users as $key => $value) {
            $users[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }


        if ($usersCs > 0 && $usersCount == 0) {
            $usersCount =   $usersCs;
        }

        return response()->json([
            'data' => $users,
            'total' =>  $usersCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }
}
