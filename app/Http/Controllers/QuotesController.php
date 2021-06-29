<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Quotes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index(Request $request)
    {



        if ($request->slug) {

            $table = 'Quotes';

            $query = Quotes::join('users', 'users.id', '=', $table . '.user_id')
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

        $Quotes =  new Quotes();
        if ($request->input('publish') == 1) {

            $Quotes->publish = 1;
            $Quotes->publish_text  = 'draft';
        } else {

            $Quotes->publish = 2;
            $Quotes->publish_text  = 'publish';
        }

        $newQuotes = new Quotes(
            [
                'author' => $request->input('author'),
                'message' => $request->input('message'),
                'publish' =>  $Quotes->publish,
                'publish_test' =>  $Quotes->publish_text,
            ]
        );

        $user->quotes()->save($newQuotes);




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
    public function show(Request $request, $page, $itemsperpage)
    {

        $skip = $request->page;
        if ($page == 1) {
            $skip = 0;
        } else {
            $skip = $page * $page;
        }

        $table = 'quotes';

        if ($request->sortBy == ""  && $request->sortDesc == "") {
            $page = $page ? $page : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $Quotes = Quotes::where('quotes.publish', 2)
                ->orderBy($table . '.created_at', 'desc')
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->select('users.name', 'users.email', 'quotes.id', 'quotes.title', 'quotes.content', 'quotes.slug', 'quotes.id', 'quotes.publish', 'quotes.image', 'quotes.created_at', 'quotes.author', 'quotes.message')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $Quotes_count = Quotes::where('quotes.publish', 2)
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $page  ? $page  : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $Quotes = Quotes::where('quotes.publish', 2)
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->select('users.name', 'users.email', 'quotes.id', 'quotes.title', 'quotes.content', 'quotes.slug', 'quotes.id', 'quotes.publish', 'quotes.image', 'quotes.created_at', 'quotes.author', 'quotes.message')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $Quotes_count = Quotes::where('quotes.publish', 2)
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->get();
        }

        $QuotesCs =   $Quotes->count();
        $QuotesCount =  $Quotes_count->count();

        foreach ($Quotes as $key => $value) {
            $Quotes[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }

        if ($QuotesCs > 0 && $QuotesCount == 0) {
            $QuotesCount =   $QuotesCs;
        }





        return response()->json([
            'data' => $Quotes,
            'total' =>  $QuotesCount,
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



        $Quotescheck = Quotes::findOrFail($id);

        if (url($Quotescheck->image) === $request->image) {
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

                $path = $request->file('image')->storeAs('public/upload_quotes', $FileNameToStore);
                $FileNameToStore = 'storage/upload_quotes/' . $FileNameToStore;

                /**
                 * Image upload End
                 *
                 */
            }
        }


        $Quotes = Quotes::findOrFail($id);

        $Quotes->title = $request->title;
        $Quotes->content = $request->content;
        $Quotes->publish = $request->publish;

        if ($request->publish == 1) {
            $Quotes->publish_text = 'draft';
        } else {
            $Quotes->publish_text = 'publish';
        }

        if (url($Quotescheck->image) === $request->image) {

            $Quotes->image   = '';
        } else if ($request->image == "") {

            $Quotes->image   = '';
        } else {

            if ($request->image) {

                $Quotes->image = $FileNameToStore;
            } else {
            }
        }

        $Quotes->update();

        $Quotesagain = Quotes::findOrFail($id);

        if ($request->image == "") {
            $image =  '';
        } else {
            $image =  url($Quotesagain->image);
        }




        return response()->json([
            'save' => $Quotes,
            'success' => 1,
            'image' =>  $image,
            'user' => $request->user(),
            'Quotes' =>  $Quotescheck,
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


        $table = Quotes::findOrFail($table_id);
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

            $Quotes = Quotes::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->select('users.name', 'users.email', 'quotes.id', 'quotes.title', 'quotes.content', 'quotes.slug', 'quotes.id', 'quotes.publish', 'quotes.image', 'quotes.created_at', 'quotes.ckeditor_log', 'quotes.message', 'quotes.author')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $Quotes_count = Quotes::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $Quotes = Quotes::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->select('users.name', 'users.email', 'quotes.id', 'quotes.title', 'quotes.content', 'quotes.slug', 'quotes.id', 'quotes.publish', 'quotes.image', 'quotes.created_at', 'quotes.ckeditor_log', 'quotes.message', 'quotes.author')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $Quotes_count = Quotes::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'quotes.user_id')
                ->get();
        }

        $QuotesCs =   $Quotes->count();
        $QuotesCount =  $Quotes_count->count();

        foreach ($Quotes as $key => $value) {
            $Quotes[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $Quotes[$key]['image'] = $value['image'] ? url($value['image']) : '';
            $Quotes[$key]['path'] = $value['path'] ? url($value['path']) : '';
        }

        if ($QuotesCs > 0 && $QuotesCount == 0) {
            $QuotesCount =   $QuotesCs;
        }
        // $Quotes = array_reverse($Quotes);
        return response()->json([
            'data' => $Quotes,
            'total' =>  $QuotesCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage
        ], 200);
    }

    public function random_item(Request $request)
    {
        $Quotes = Quotes::inRandomOrder()
            ->select('message', 'author', 'id')
            ->limit(1)
            ->first();

        return response()->json([
            'data' =>  $Quotes,
            'success' => 1,
            '_benchmark' => microtime(true) -  $this->time_start
        ], 200);
    }
}
