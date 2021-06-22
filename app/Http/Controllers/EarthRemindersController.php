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

        if ($request->slug) {

            $table = 'earthreminders';

            $query = earthreminders::join('users', 'users.id', '=', $table . '.user_id')
                ->where($table . '.slug', $request->slug)
                ->select('users.name', 'users.email', $table . '.id', $table . '.title', $table . '.content', $table . '.slug', $table . '.id', $table . '.publish', $table . '.created_at', $table . '.image')
                ->get();

            foreach ($query as $key => $value) {
                $query[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
                $query[$key]['image'] = url($value['image']);
            }
        }




        return response()->json([
            'data' => $query,
            'success' => 1,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {



        $user = User::findOrFail($request->user()->id);


        /**
         * Image upload
         *
         */

        if ($request->file('image')) {

            $filenameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('image')->getClientOriginalExtension();

            $FileNameToStore = $filename . '_' . time() . "." . $extension;

            $path = $request->file('image')->storeAs('public/upload_worldreminders', $FileNameToStore);

            $FileNameToStore = 'storage/upload_worldreminders/' . $FileNameToStore;
        } else {

            $FileNameToStore = null;
        }


        /**
         * Image upload
         *
         */


        $earthreminders =  new EarthReminders();
        if ($request->input('publish') == 1) {

            $earthreminders->publish = 1;
            $earthreminders->publish_text  = 'draft';
        } else {

            $earthreminders->publish = 2;
            $earthreminders->publish_text  = 'publish';
        }

        $newearthreminders = new EarthReminders(
            [
                'image' => $FileNameToStore,
                'title' => $request->input('title'),
                'subtitle' => $request->input('subtitle'),
                'slug' => Str::slug($request->input('title') . "-" . time(), '-'),
                'subtitle' => $request->input('subtitle'),
                'author' => $request->input('author'),
                'event_date' => $request->input('event_date'),
                'country' => $request->input('country'),
                'publish' =>  $earthreminders->publish,
                'publish_test' =>  $earthreminders->publish_text,
                'content' =>  $request->input('content'),
            ]
        );

        $user->earthreminders()->save($newearthreminders);




        return response()->json([
            'success' => true,
            'user' => $request->user(),
            '_benchmark' => microtime(true) -  $this->time_start,
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
    public function show(Request $request, $page, $itemsperpage, $date)
    {
        $date_parts = explode("-", $date); //' YYYY-MM-DD

        $skip = $request->page;
        if ($page == 1) {
            $skip = 0;
        } else {
            $skip = $page * $page;
        }

        $table = 'earthreminders';

        if ($request->sortBy == ""  && $request->sortDesc == "") {
            $page = $page ? $page : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;


            $date_parts = explode("-", $date); //' YYYY-MM-DD
            $earthreminders = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',  $date_parts[1])
                // ->whereDay('earthreminders.event_date',  $date_parts[2])
                ->orderBy($table . '.created_at', 'desc')
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->select('users.name', 'users.email', 'earthreminders.id', 'earthreminders.title', 'earthreminders.content', 'earthreminders.slug',  'earthreminders.publish', 'earthreminders.image', 'earthreminders.created_at', 'earthreminders.author', 'earthreminders.subtitle', 'earthreminders.event_date', 'earthreminders.country')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $earthreminders_count = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',  $date_parts[1])
                // ->whereDay('earthreminders.event_date',  $date_parts[2])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $page  ? $page  : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $earthreminders = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',  $date_parts[1])
                // ->whereDay('earthreminders.event_date',  $date_parts[2])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->select('users.name', 'users.email', 'earthreminders.id', 'earthreminders.title', 'earthreminders.content', 'earthreminders.slug',  'earthreminders.publish', 'earthreminders.image', 'earthreminders.created_at', 'earthreminders.author', 'earthreminders.subtitle', 'earthreminders.event_date', 'earthreminders.country')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $earthreminders_count = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',  $date_parts[1])
                // ->whereDay('earthreminders.event_date',  $date_parts[2])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->get();
        }

        $earthremindersCs =   $earthreminders->count();
        $earthremindersCount =  $earthreminders_count->count();




        $now = Carbon::now();
        foreach ($earthreminders as $key => $value) {
            $earthreminders[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $earthreminders[$key]['date'] = Carbon::parse($value['event_date'])->format('F d, Y');
            $date = Carbon::parse($value['event_date']);
            // $earthreminders[$key]['anniversary'] = $date->diffInDays($now);
            $earthreminders[$key]['anniversary'] = $date->diffInYears($now);
            $earthreminders[$key]['image'] = $value['image'] ? url($value['image']) : '';
        }

        if ($earthremindersCs > 0 && $earthremindersCount == 0) {
            $earthremindersCount =   $earthremindersCs;
        }





        return response()->json([
            'data' => $earthreminders,
            'total' =>  $earthremindersCount,
            'skip' => $skip,
            'take' => $itemsperpage,
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
    public function update(Request $request, $id)
    {



        $earthreminderscheck = EarthReminders::findOrFail($id);

        if (url($earthreminderscheck->image) === $request->image) {
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

                $path = $request->file('image')->storeAs('public/upload_earthreminders', $FileNameToStore);
                $FileNameToStore = 'storage/upload_earthreminders/' . $FileNameToStore;

                /**
                 * Image upload End
                 *
                 */
            }
        }


        $earthreminders = EarthReminders::findOrFail($id);

        $earthreminders->title = $request->title;
        $earthreminders->subtitle = $request->subtitle;
        $earthreminders->event_date = $request->event_date;
        $earthreminders->country = $request->country;
        $earthreminders->author = $request->author;
        $earthreminders->content = $request->content;
        $earthreminders->publish = $request->publish;

        if ($request->publish == 1) {
            $earthreminders->publish_text = 'draft';
        } else {
            $earthreminders->publish_text = 'publish';
        }

        if (url($earthreminderscheck->image) === $request->image) {

            $earthreminders->image   = '';
        } else if ($request->image == "") {

            $earthreminders->image   = '';
        } else {

            if ($request->image) {

                $earthreminders->image = $FileNameToStore;
            } else {
            }
        }

        $earthreminders->update();

        $earthremindersagain = EarthReminders::findOrFail($id);

        if ($request->image == "") {
            $image =  '';
        } else {
            $image =  url($earthremindersagain->image);
        }




        return response()->json([
            'save' => $earthreminders,
            'success' => 1,
            'image' =>  $image,
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


    public function delete(Request $request, $table_id)
    {


        $table = earthreminders::findOrFail($table_id);
        $table->delete();



        return response()->json([
            'success' => 1,
            'user' => $request->user(),
            '_benchmark' => microtime(true) -  $this->time_start,
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

            $earthreminders = earthreminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->select('users.name', 'users.email', 'earthreminders.*')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $earthreminders_count = earthreminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $earthreminders = earthreminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->select('users.name', 'users.email', 'earthreminders.*')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $earthreminders_count = earthreminders::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->get();
        }

        $earthremindersCs =   $earthreminders->count();
        $earthremindersCount =  $earthreminders_count->count();

        foreach ($earthreminders as $key => $value) {
            $earthreminders[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $earthreminders[$key]['image'] = $value['image'] ? url($value['image']) : '';
            $earthreminders[$key]['path'] = $value['path'] ? url($value['path']) : '';
        }

        if ($earthremindersCs > 0 && $earthremindersCount == 0) {
            $earthremindersCount =   $earthremindersCs;
        }
        // $earthreminders = array_reverse($earthreminders);
        return response()->json([
            'data' => $earthreminders,
            'total' =>  $earthremindersCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage
        ], 200);
    }

    public function show_month(Request $request, $page, $itemsperpage, $month)
    {
        $month = Carbon::parse($month)->format('m');


        $skip = $request->page;
        if ($page == 1) {
            $skip = 0;
        } else {
            $skip = $page * $page;
        }

        $table = 'earthreminders';

        if ($request->sortBy == ""  && $request->sortDesc == "") {
            $page = $page ? $page : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;


            $earthreminders = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date', $month)
                ->orderBy($table . '.created_at', 'desc')
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->select('users.name', 'users.email', 'earthreminders.id', 'earthreminders.title', 'earthreminders.content', 'earthreminders.slug',  'earthreminders.publish', 'earthreminders.image', 'earthreminders.created_at', 'earthreminders.author', 'earthreminders.subtitle', 'earthreminders.event_date', 'earthreminders.country')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $earthreminders_count = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',   $month)

                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $page  ? $page  : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $earthreminders = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',  $month)

                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->select('users.name', 'users.email', 'earthreminders.id', 'earthreminders.title', 'earthreminders.content', 'earthreminders.slug',  'earthreminders.publish', 'earthreminders.image', 'earthreminders.created_at', 'earthreminders.author', 'earthreminders.subtitle', 'earthreminders.event_date', 'earthreminders.country')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $earthreminders_count = EarthReminders::where('earthreminders.publish', 2)
                ->whereMonth('earthreminders.event_date',   $month)

                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'earthreminders.user_id')
                ->get();
        }

        $earthremindersCs =   $earthreminders->count();
        $earthremindersCount =  $earthreminders_count->count();




        $now = Carbon::now();
        foreach ($earthreminders as $key => $value) {
            $earthreminders[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $earthreminders[$key]['date'] = Carbon::parse($value['event_date'])->format('F d, Y');
            $date = Carbon::parse($value['event_date']);
            // $earthreminders[$key]['anniversary'] = $date->diffInDays($now);
            $earthreminders[$key]['anniversary'] = $date->diffInYears($now);
            $earthreminders[$key]['image'] = $value['image'] ? url($value['image']) : '';
        }




        if ($earthremindersCs > 0 && $earthremindersCount == 0) {
            $earthremindersCount =   $earthremindersCs;
        }





        return response()->json([
            'month' => $month,
            'data' => $earthreminders,
            'total' =>  $earthremindersCount,
            'skip' => $skip,
            'take' => $itemsperpage,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }
}
