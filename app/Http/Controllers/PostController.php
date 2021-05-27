<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

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
    // public function create()
    public function create( $id)
    {
        $user= User::findOrFail($id);

        $user->posts()->save(new Post(['title'=>'test','content'=>'test']));
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
        $user = User::findOrFail($id);

        foreach($user->posts as $post){

            echo $post->title ." " .$post->content . '<br/>';
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
    public function update(Request $request, $user_id,$post_id)
    {

        // var_dump($user_id);
        // echo '<br>';
        // var_dump($post_id);
        // die();
        $user = User::findOrFail($user_id);

        $user->posts()->whereId($post_id)->update(['title'=>'my title','content'=>'my content']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id,$post_id)
    {

        // $datum  = FaqFile::find($id);
        // $datum->delete();

        $user = User::findOrFail($user_id);

        $user->posts()->whereId($post_id)->delete();
    }
}