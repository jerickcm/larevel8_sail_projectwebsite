<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Ckeditorupload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $time_start = microtime(true);
        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'success' => true,
            '_elapsed_time' => $timeend,
            $request->user()
            // 'errors' => $validator->errors(),
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
        $filenameWithExt = $request->file('image')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file('image')->getClientOriginalExtension();

        $FileNameToStore = $filename . '_' . time() . "." . $extension;

        $path = $request->file('image')->storeAs('public/upload_post', $FileNameToStore);
        $FileNameToStore = 'storage/upload_post/' . $FileNameToStore;

        /**
         * Image upload
         *
         */

        $newpost = new Post(
            [
                'title' => $request->input('title'),
                'publish' => $request->input('publish'),
                'content' => $request->input('content'),
                'slug' => Str::slug($request->input('title') . "-" . time(), '-'),
                'image' =>  url($FileNameToStore)
            ]
        );

        $user->posts()->save($newpost);

        $time_start = microtime(true);
        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'success' => true,
            '_elapsed_time' => $timeend,
            'user' => $request->user(),
            'user_id' => $request->user()->id,
            'data' => $request->input('name'),
            'path' =>  url($FileNameToStore)

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

    public function show_($id)
    {
        $user = User::findOrFail($id);

        foreach ($user->posts as $post) {

            echo $post->title . " " . $post->content . '<br/>';
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
    public function update(Request $request, $user_id, $post_id)
    {
        $user = User::findOrFail($user_id);

        $user->posts()->whereId($post_id)->update(['title' => 'my title', 'content' => 'my content']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $post_id)
    {

        // $datum  = FaqFile::find($id);
        // $datum->delete();

        $user = User::findOrFail($user_id);

        $user->posts()->whereId($post_id)->delete();
    }


    public function ckeditor(Request $request)
    {

        $filenameWithExt = $request->file('upload')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        $extension = $request->file('upload')->getClientOriginalExtension();

        $FileNameToStore = $filename . '_' . time() . "." . $extension;

        $path = $request->file('upload')->storeAs('public/upload_ckeditor', $FileNameToStore);

        $data["domain"] = $_SERVER['SERVER_NAME'];
        $FileNameToStore = 'storage/upload_ckeditor/' . $FileNameToStore;

        $mydata["ret"] =  $filenameWithExt;

        $image_log = new Ckeditorupload;
        $image_log->user_id = $request->user()->id;
        $image_log->image_name = $path;
        $image_log->save();


        return response()->json([
            'data' => $request,
            'user' => $request->user(),
            'success' => 1,
            'path' => $path,
            'url' =>  $mydata["url"] =  url($FileNameToStore)
        ], 200);
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

            $posts = Post::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.image', 'posts.created_at')
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $posts_count = Post::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->get();
        } else {

            if ($request->sortDesc) {
                $order = 'desc';
            } else {
                $order = 'asc';
            }

            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('itemsPerPage') ? $request->get('itemsPerPage') : 10;

            $posts = Post::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.image', 'posts.created_at')
                ->orderBy($request->sortBy, $order)
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->take($request->itemsPerPage)
                ->get();

            $posts_count = Post::where([['title', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['users.name', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['slug', 'LIKE', "%" . $request->search . "%"]])
                ->orWhere([['publish_text', 'LIKE', "%" . $request->search . "%"]])
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->get();
        }

        $postsCs =   $posts->count();
        $postsCount =  $posts_count->count();


        if ($postsCs > 0 && $postsCount == 0) {
            $postsCount =   $postsCs;
        }

        return response()->json([
            'data' => $posts,
            'total' =>  $postsCount,
            'skip' => $skip,
            'take' => $request->itemsPerPage
        ], 200);
    }

    public function datatable_delete(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $post->delete();
        return response()->json([

            'success' => 1,
            'user' => $request->user()
        ], 200);
    }

    public function datatable_update(Request $request)
    {
        $postcheck = Post::findOrFail($request->post_id);
        // var_dump($postcheck );

        if ($postcheck->image === $request->image) {
        } else {

            if ($request->image) {
                /**
                 * Image upload
                 *
                 */
                $filenameWithExt = $request->file('image')->getClientOriginalName();

                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                $extension = $request->file('image')->getClientOriginalExtension();

                $FileNameToStore = $filename . '_' . time() . "." . $extension;

                $path = $request->file('image')->storeAs('public/upload_post', $FileNameToStore);
                $FileNameToStore = 'storage/upload_post/' . $FileNameToStore;

                /**
                 * Image upload
                 *
                 */
            }
        }


        $post = Post::findOrFail($request->post_id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->publish = $request->publish;
        if ($request->publish == 1) {
            $post->publish_text = 'draft';
        } else {
            $post->publish_text = 'publish';
        }

        if ($postcheck->image === $request->image) {
            $image = '';
        } else {

            if ($request->image) {
                $post->image = url($FileNameToStore);
                $image  = $post->image;
            } else {
                $image = '';
            }
        }

        $post->update();
        return response()->json([
            'image' => $image,
            'data' =>  $post,
            'success' => 1,
            'user' => $request->user()
        ], 200);
    }

    public function show_by_get(Request $request, $page)
    {
        $time_start = microtime(true);
        $page = $page;

        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.created_at', 'posts.image')
            ->orderBy('posts.created_at', 'desc')
            ->where('posts.publish', 2)
            ->limit(10)
            ->offset(($page - 1) * 10)
            ->take(10)
            ->get();

        foreach ($posts as $key => $value) {
            $posts[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }


        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'data' => $posts,
            'success' => 1,
            'benchmark' =>  $timeend
        ], 200);
    }

    public function show(Request $request)
    {
        $time_start = microtime(true);
        $page = $request->page;

        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.created_at', 'posts.image')
            ->orderBy('posts.created_at', 'desc')
            ->where('posts.publish', 2)
            ->limit(10)
            ->offset(($page - 1) * 10)
            ->take(10)
            ->get();

        foreach ($posts as $key => $value) {
            $posts[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }


        $time_end = microtime(true);
        $timeend = $time_end - $time_start;

        return response()->json([
            'data' => $posts,
            'success' => 1,
            'benchmark' =>  $timeend
        ], 200);
    }


    public function show_by_slug(Request $request)
    {

        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.slug', $request->slug)
            ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.created_at', 'posts.image')
            ->get();

        foreach ($posts as $key => $value) {
            $posts[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
        }

        return response()->json([
            'data' => $posts,
            'success' => 1,
        ], 200);
    }
}
