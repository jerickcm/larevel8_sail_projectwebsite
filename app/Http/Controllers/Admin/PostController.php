<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ckeditorupload;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($slug)
    {

        //
        //
        //

        // return response()->json([
        //     'success' => true,
        //       '_benchmark' => microtime(true) -  $this->time_start,
        //     // $request->user()
        //     // 'errors' => $validator->errors(),
        // ], 200);


        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.slug', $slug)
            ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.created_at', 'posts.image')
            ->get();

        foreach ($posts as $key => $value) {
            $posts[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $posts[$key]['image'] = url($value['image']);
        }

        return response()->json([
            'data' => $posts,
            'success' => 1,
        ], 200);
    }


    public function index_(Request $request)
    {




        return response()->json([
            'success' => true,
              '_benchmark' => microtime(true) -  $this->time_start,
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
        if ($request->file('image')) {

            $filenameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('image')->getClientOriginalExtension();

            $FileNameToStore = $filename . '_' . time() . "." . $extension;

            $path = $request->file('image')->storeAs('public/upload_post', $FileNameToStore);
            $FileNameToStore = 'storage/upload_post/' . $FileNameToStore;
        } else {

            $FileNameToStore = null;
        }


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
                'image' => $FileNameToStore,
                'ckeditor_log' => $request->input('ckeditor_log')
            ]
        );

        $user->posts()->save($newpost);





        return response()->json([
            'success' => true,
              '_benchmark' => microtime(true) -  $this->time_start,
            'user' => $request->user(),
            'user_id' => $request->user()->id,
            'data' => $request->input('name'),
            'path' =>  $FileNameToStore ? url($FileNameToStore) : "",
            'path_pub' =>  $FileNameToStore ? url($path) : "",

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
    // public function update(Request $request, $user_id, $post_id)
    // {
    //     $user = User::findOrFail($user_id);

    //     $user->posts()->whereId($post_id)->update(['title' => 'my title', 'content' => 'my content']);
    // }

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


        // $access_token = $request->header('identifier');



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
        $image_log->image_name = $FileNameToStore;
        $image_log->instance_identifier = $request->header('identifier');
        $image_log->save();


        return response()->json([
            'data' => $request,
            'user' => $request->user(),
            'success' => 1,
            'path' => $path,
            'url' =>  $mydata["url"] =  url($FileNameToStore),
            'public' =>  $mydata["url"] =  url($path),
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
                ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.image', 'posts.created_at', 'posts.ckeditor_log')
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
                ->select('users.name', 'users.email', 'posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.id', 'posts.publish', 'posts.image', 'posts.created_at', 'posts.ckeditor_log')
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

        foreach ($posts as $key => $value) {
            $posts[$key]['human_date'] = Carbon::parse($value['created_at'])->diffForHumans();
            $posts[$key]['image'] = $value['image'] ? url($value['image']) : '';
            $posts[$key]['path'] = $value['path'] ? url($value['path']) : '';
        }


        if ($postsCs > 0 && $postsCount == 0) {
            $postsCount =   $postsCs;
        }
        // $posts = array_reverse($posts);
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

    public function update(Request $request)
    {

        $postcheck = Post::findOrFail($request->post_id);

        if (url($postcheck->image) === $request->image) {
        } else if (secure_url($postcheck->image) === $request->image) {
        } else if ($request->image === "") {
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

        if (url($postcheck->image) === $request->image) {
        } else if (secure_url($postcheck->image) === $request->image) {
        } else if ($request->image == "") {

            $post->image   = '';
        } else {

            if ($request->image) {
                $post->image = $FileNameToStore;
                $image  = $post->image;
            } else {
                $image = '';
            }
        }

        $post->update();

        $postagain = Post::findOrFail($request->post_id);

        if ($request->image == "") {
            $image =  '';
        } else if (secure_url($postcheck->image) === $request->image) {
            $image =  secure_url($postagain->image);
        } else {
            $image =  url($postagain->image);
        }

        return response()->json([
            'image' => $image,
            'data' =>  $post,
            'success' => 1,
            'user' => $request->user()
        ], 200);
    }

    public function show_by_get(Request $request, $page)
    {

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
            $posts[$key]['image'] = url($value['image']);
        }




        return response()->json([
            'data' => $posts,
            'success' => 1,
            '_benchmark' => microtime(true) -  $this->time_start
        ], 200);
    }

    public function show(Request $request)
    {

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
            $posts[$key]['image'] = url($value['image']);
        }





        return response()->json([
            'data' => $posts,
            'success' => 1,
            '_benchmark' => microtime(true) -  $this->time_start
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
            $posts[$key]['image'] = url($value['image']);
        }

        return response()->json([
            'data' => $posts,
            'success' => 1,
        ], 200);
    }
}
