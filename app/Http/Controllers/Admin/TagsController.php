<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagsblogs;
use Carbon\Carbon;

class TagsController extends Controller
{

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

            $users = Tagsblogs::where([['name', 'LIKE', "%" . $request->search . "%"]])
            ->select('id','name', 'created_at')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $users_count = Tagsblogs::where([['name', 'LIKE', "%" . $request->search . "%"]])
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $users = Tagsblogs::where([['name', 'LIKE', "%" . $request->search . "%"]])
                ->select('id','name', 'created_at')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $users_count = Tagsblogs::where([['name', 'LIKE', "%" . $request->search . "%"]])
                ->get();
        }

        $usersCs =   $users->count();
        $usersCount =  $users_count->count();

        foreach ($users as $key => $value) {
            // $users[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $users[$key]['created'] = Carbon::parse($value['created_at'])->diffInSeconds() > 86400 ? Carbon::parse($value['created_at'])->format('F d ,Y') : Carbon::parse($value['created_at'])->diffForHumans();
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

    public function update(Request $request)
    {

        $tag = Tagsblogs::where('id', $request->id)->first();
        $tag->name  = $request->name;
        $tag->save();

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
        $tag = Tagsblogs::findOrFail($request->id);
        $tag->delete();
    }

}
