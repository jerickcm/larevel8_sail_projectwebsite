<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\EarthReminders;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EarthRemindersController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $time_start = microtime(true);

        if ($request->slug) {

            $table = 'EarthReminders';

            $query = EarthReminders::join('users', 'users.id', '=', $table . '.user_id')
                ->where($table . '.slug', $request->slug)
                ->select('users.name', 'users.email', $table . '.id', $table . '.title', $table . '.content', $table . '.slug', $table . '.id', $table . '.publish', $table . '.created_at', $table . '.image')
                ->get();

            foreach ($query as $key => $value) {
                $query[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
                $query[$key]['image'] = url($value['image']);
            }
        }

        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'data' => $query,
            'success' => 1,
            '_benchmark' => $timeend,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {

        $time_start = microtime(true);

        $user = User::findOrFail($request->user()->id);

        $EarthReminders =  new EarthReminders();
        if ($request->input('publish') == 1) {

            $EarthReminders->publish = 1;
            $EarthReminders->publish_text  = 'draft';
        } else {

            $EarthReminders->publish = 2;
            $EarthReminders->publish_text  = 'publish';
        }

        $newEarthReminders = new EarthReminders(
            [
                'author' => $request->input('author'),
                'message' => $request->input('message'),
                'publish' =>  $EarthReminders->publish,
                'publish_test' =>  $EarthReminders->publish_text,
            ]
        );

        $user->EarthReminders()->save($newEarthReminders);

        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'success' => true,
            'user' => $request->user(),
            '_benchmark' => $timeend,
        ], 200);
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
    public function show(Request $request, $page, $itemsperpage)
    {
        $time_start = microtime(true);
        $skip = $request->page;
        if ($page == 1) {
            $skip = 0;
        } else {
            $skip = $page * $page;
        }

        $table = 'EarthReminders';

        if ($request->sortBy == ""  && $request->sortDesc == "") {
            $page = $page ? $page : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $EarthReminders = EarthReminders::where('earthreminderspublish', 2)
                ->orderBy($table . '.created_at', 'desc')
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->select('users.name', 'users.email', 'earthremindersid', 'earthreminderstitle', 'earthreminderscontent', 'earthremindersslug', 'earthremindersid', 'earthreminderspublish', 'earthremindersimage', 'earthreminderscreated_at', 'earthremindersauthor', 'earthremindersmessage')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $EarthReminders_count = EarthReminders::where('earthreminderspublish', 2)
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $page  ? $page  : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $EarthReminders = EarthReminders::where('earthreminderspublish', 2)
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->select('users.name', 'users.email', 'earthremindersid', 'earthreminderstitle', 'earthreminderscontent', 'earthremindersslug', 'earthremindersid', 'earthreminderspublish', 'earthremindersimage', 'earthreminderscreated_at', 'earthremindersauthor', 'earthremindersmessage')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $EarthReminders_count = EarthReminders::where('earthreminderspublish', 2)
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->get();
        }

        $EarthRemindersCs =   $EarthReminders->count();
        $EarthRemindersCount =  $EarthReminders_count->count();

        foreach ($EarthReminders as $key => $value) {
            $EarthReminders[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }

        if ($EarthRemindersCs > 0 && $EarthRemindersCount == 0) {
            $EarthRemindersCount =   $EarthRemindersCs;
        }

        $time_end = microtime(true);
        $timeend = $time_end - $time_start;


        return response()->json([
            'data' => $EarthReminders,
            'total' =>  $EarthRemindersCount,
            'skip' => $skip,
            'take' => $itemsperpage,
            '_benchmark' => $timeend,
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
    public function update(Request $request, $id)
    {

        $time_start = microtime(true);

        $EarthReminderscheck = EarthReminders::findOrFail($id);

        if (url($EarthReminderscheck->image) === $request->image) {
        } else if ($request->image === "") {
        } else {

            if ($request->image) {
                /**
                 * Image upload Start
                 *
                 */
                $filenameWithExt = $request->file('image')->getClientOriginalName();

                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                $extension = $request->file('image')->getClientOriginalExtension();

                $FileNameToStore = $filename . '_' . time() . "." . $extension;

                $path = $request->file('image')->storeAs('public/upload_EarthReminders', $FileNameToStore);
                $FileNameToStore = 'storage/upload_EarthReminders/' . $FileNameToStore;

                /**
                 * Image upload End
                 *
                 */
            }
        }


        $EarthReminders = EarthReminders::findOrFail($id);

        $EarthReminders->title = $request->title;
        $EarthReminders->content = $request->content;
        $EarthReminders->publish = $request->publish;

        if ($request->publish == 1) {
            $EarthReminders->publish_text = 'draft';
        } else {
            $EarthReminders->publish_text = 'publish';
        }

        if (url($EarthReminderscheck->image) === $request->image) {

            $EarthReminders->image   = '';
        } else if ($request->image == "") {

            $EarthReminders->image   = '';
        } else {

            if ($request->image) {

                $EarthReminders->image = $FileNameToStore;
            } else {
            }
        }

        $EarthReminders->update();

        $EarthRemindersagain = EarthReminders::findOrFail($id);

        if ($request->image == "") {
            $image =  '';
        } else {
            $image =  url($EarthRemindersagain->image);
        }

        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'save' => $EarthReminders,
            'success' => 1,
            'image' =>  $image,
            'user' => $request->user(),
            'EarthReminders' =>  $EarthReminderscheck,
            '_benchmark' => $timeend,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete(Request $request, $table_id)
    {
        $time_start = microtime(true);

        $table = EarthReminders::findOrFail($table_id);
        $table->delete();

        $time_end = microtime(true);
        $timeend = $time_end - $time_start;
        return response()->json([
            'success' => 1,
            'user' => $request->user(),
            '_benchmark' => $timeend,
        ], 200);
    }

    //


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

            $EarthReminders = EarthReminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->select('users.name', 'users.email', 'earthremindersid', 'earthreminderstitle', 'earthreminderscontent', 'earthremindersslug', 'earthremindersid', 'earthreminderspublish', 'earthremindersimage', 'earthreminderscreated_at', 'earthremindersckeditor_log', 'earthremindersmessage', 'earthremindersauthor')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $EarthReminders_count = EarthReminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $EarthReminders = EarthReminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->select('users.name', 'users.email', 'earthremindersid', 'earthreminderstitle', 'earthreminderscontent', 'earthremindersslug', 'earthremindersid', 'earthreminderspublish', 'earthremindersimage', 'earthreminderscreated_at', 'earthremindersckeditor_log', 'earthremindersmessage', 'earthremindersauthor')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $EarthReminders_count = EarthReminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthremindersuser_id')
                ->get();
        }

        $EarthRemindersCs =   $EarthReminders->count();
        $EarthRemindersCount =  $EarthReminders_count->count();

        foreach ($EarthReminders as $key => $value) {
            $EarthReminders[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $EarthReminders[$key]['image'] = $value['image'] ? url($value['image']) : '';
            $EarthReminders[$key]['path'] = $value['path'] ? url($value['path']) : '';
        }

        if ($EarthRemindersCs > 0 && $EarthRemindersCount == 0) {
            $EarthRemindersCount =   $EarthRemindersCs;
        }
        // $EarthReminders = array_reverse($EarthReminders);
        return response()->json([
            'data' => $EarthReminders,
            'total' =>  $EarthRemindersCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage
        ], 200);
    }
}
