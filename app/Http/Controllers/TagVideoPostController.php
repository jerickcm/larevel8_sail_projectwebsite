<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class TagVideoPostController extends Controller
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
    public function create()
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tag_video($id, $tag_id)
    {
        $Video = \App\Models\Video::findOrFail($id);
        // $Video = \App\Models\Video::create(['usert_id'=>'1','name'=>'test posting']);

        $tag =  \App\Models\Tag::findOrFail($tag_id);

        $Video->tags()->save($tag);
    }

    public function tag_post($id, $tag_id)
    {
        $post = \App\Models\Post::findOrFail($id);
        // $post = \App\Models\Post::create(['usert_id'=>'1','name'=>'test Video']);

        $tag =  \App\Models\Tag::findOrFail($tag_id);

        $post->tags()->save($tag);
    }



    public function update_tagvideo($id, $tag_id)
    {
        $Video = \App\Models\Video::findOrFail($id);
        // $Video = \App\Models\Video::create(['usert_id'=>'1','name'=>'test posting']);

        $tag =  \App\Models\Tag::findOrFail($tag_id);

        $Video->tags()->save($tag);
    }

    public function update_tagpost($id, $tag_id)
    {
        $post = \App\Models\Post::findOrFail($id);
        // $post = \App\Models\Post::create(['usert_id'=>'1','name'=>'test Video']);

        $tag =  \App\Models\Tag::findOrFail($tag_id);

        $post->tags()->save($tag);
    }


    public function show_tagpost($id)
    {

        $post  = Post::findOrFail($id);
        // echo 'run';
        // dd($post );
        foreach ($post->tags as $tag) {
            // echo 'tt';
            echo ($tag);
        }
    }

    public function show_tagvideo($id)
    {

        $video = \App\Models\Video::findOrFail($id);

        foreach ($video->tags as $tags) {

            echo $tags;
        }
    }

    public function updatedata_tagpost($id, $tag_id)
    {
        $post  = Post::findOrFail($id);
        // $tag  = \App\Models\Tag::findOrFail($tag_id);

        // $post->tags()->save($tag );
        //  dd($post->tags);
        $arr = [];
        foreach ($post->tags as $tagme => $val) {
            //     // echo 'tt';
            // echo $tagme;
            // echo $val->pivot->taggable_type . ' ' . $val->name;
            echo $val->pivot->taggable_type . ' ' . $val->name;
            array_push($arr,$val->name);
            // $arr[$val] = $val->name;
            //     echo ('<br>');
        }

        var_dump($arr);
    }

    public function updatedata_tagvideo($id, $tag_id)
    {

        $video  = \App\Models\Video::findOrFail($id);
        $tag  = \App\Models\Tag::findOrFail($tag_id);
        $video->tags()->save($tag);

        foreach ($video->tags as $tagme) {
            // echo 'tt';
            echo ($tagme);
        }
    }

    public function destroy_tagpost($id, $tag_id)
    {
        $post  = Post::findOrFail($id);
        foreach ($post->tags as $tagcontent) {
            $tagcontent->where('id',1)->delete();
        }

    }

    public function destroy_videopost($id, $tag_id)
    {
        $Video  = \App\Models\Video::findOrFail($id);
        foreach ($Video->tags as $tagcontent => $tagval) {
            $tagcontent->where('id',$tag_id)->delete();
        }
    }
}
