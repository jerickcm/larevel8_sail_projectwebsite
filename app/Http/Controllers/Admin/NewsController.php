<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        if ($request->slug) {

            $table = 'news';

            $query = News::join('users', 'users.id', '=', $table . '.user_id')
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

            $path = $request->file('image')->storeAs('public/upload_news', $FileNameToStore);

            $FileNameToStore = 'storage/upload_news/' . $FileNameToStore;
        } else {

            $FileNameToStore = null;
        }


        /**
         * Image upload
         *
         */

        $News =  new News();
        if ($request->input('publish') == 1) {

            $News->publish = 1;
            $News->publish_text  = 'draft';
        } else {

            $News->publish = 2;
            $News->publish_text  = 'publish';
        }

        $newNews = new News(
            [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'slug' => Str::slug($request->input('title') . "-" . time(), '-'),
                'image' => $FileNameToStore,
                'publish' =>  $News->publish,
                'publish_test' =>  $News->publish_text,
                'ckeditor_log' => $request->input('ckeditor_log')
            ]
        );

        $user->News()->save($newNews);




        return response()->json([
            'save' =>  $newNews,
            'success' => true,
            'publish' => $News->publish,
            'user' => $request->user(),
            'path' =>  $FileNameToStore ? url($FileNameToStore) : "",
            'path_pub' =>  $FileNameToStore ? url($path) : "",
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

        $table = 'news';

        if ($request->sortBy == ""  && $request->sortDesc == "") {
            $page = $page ? $page : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $news = News::where('news.publish', 2)
                ->orderBy($table . '.created_at', 'desc')
                ->join('users', 'users.id', '=', 'news.user_id')
                ->select('users.name', 'users.email', 'news.id', 'news.title', 'news.content', 'news.slug', 'news.id', 'news.publish', 'news.image', 'news.created_at')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $news_count = News::where('news.publish', 2)
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'news.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $page  ? $page  : 1;
            $limit = $itemsperpage ? $itemsperpage : 10;

            $news = News::where('news.publish', 2)
                ->join('users', 'users.id', '=', 'news.user_id')
                ->select('users.name', 'users.email', 'news.id', 'news.title', 'news.content', 'news.slug', 'news.id', 'news.publish', 'news.image', 'news.created_at')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($itemsperpage)
                ->get();

            $news_count = News::where('news.publish', 2)
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'news.user_id')
                ->get();
        }

        $newsCs =   $news->count();
        $newsCount =  $news_count->count();

        foreach ($news as $key => $value) {
            $news[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $news[$key]['image'] = url($value['image']);
            $news[$key]['path'] = url($value['path']);
        }

        if ($newsCs > 0 && $newsCount == 0) {
            $newsCount =   $newsCs;
        }


        return response()->json([
            'data' => $news,
            'total' =>  $newsCount,
            'skip' => $skip,
            'take' => $itemsperpage,
            '_benchmark' => microtime(true) -  $this->time_start
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



        $Newscheck = News::findOrFail($id);

        if (url($Newscheck->image) === $request->image) {
        } else if (secure_url($Newscheck->image) === $request->image) {
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

                $path = $request->file('image')->storeAs('public/upload_news', $FileNameToStore);
                $FileNameToStore = 'storage/upload_news/' . $FileNameToStore;

                /**
                 * Image upload End
                 *
                 */
            }
        }


        $News = News::findOrFail($id);

        $News->title = $request->title;
        $News->content = $request->content;
        $News->publish = $request->publish;

        if ($request->publish == 1) {
            $News->publish_text = 'draft';
        } else {
            $News->publish_text = 'publish';
        }

        if (url($Newscheck->image) === $request->image) {
        } else if (secure_url($Newscheck->image) === $request->image) {
        } else if ($request->image == "") {

            $News->image   = '';
        } else {

            if ($request->image) {

                $News->image = $FileNameToStore;
            } else {
            }
        }

        $News->update();

        $Newsagain = News::findOrFail($id);

        if ($request->image == "") {
            $image =  '';
        } else if (secure_url($Newscheck->image) === $request->image) {

            $image =  secure_url($Newsagain->image);
        } else {

            $image =  url($Newsagain->image);
        }




        return response()->json([
            'save' => $News,
            'success' => 1,
            'image' =>  $image,
            'user' => $request->user(),
            'News' =>  $Newscheck,
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


        $table = News::findOrFail($table_id);
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

            $news = News::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'news.user_id')
                ->select('users.name', 'users.email', 'news.id', 'news.title', 'news.content', 'news.slug', 'news.id', 'news.publish', 'news.image', 'news.created_at', 'news.ckeditor_log')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $news_count = News::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'news.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $news = News::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'news.user_id')
                ->select('users.name', 'users.email', 'news.id', 'news.title', 'news.content', 'news.slug', 'news.id', 'news.publish', 'news.image', 'news.created_at', 'news.ckeditor_log')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $news_count = News::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'news.user_id')
                ->get();
        }

        $newsCs =   $news->count();
        $newsCount =  $news_count->count();

        foreach ($news as $key => $value) {
            $news[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $news[$key]['image'] = $value['image'] ? url($value['image']) : '';
            $news[$key]['path'] = $value['path'] ? url($value['path']) : '';
        }

        if ($newsCs > 0 && $newsCount == 0) {
            $newsCount =   $newsCs;
        }
        // $news = array_reverse($news);
        return response()->json([
            'data' => $news,
            'total' =>  $newsCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage
        ], 200);
    }
}
