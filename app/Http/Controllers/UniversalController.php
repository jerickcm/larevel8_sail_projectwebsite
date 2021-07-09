<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;
use App\Models\Blog;
use App\Models\Post;
use App\Models\UserDetails;
use App\Models\Tagsblogs;
class UniversalController extends Controller
{
    public function tags()
    {
        $tags = Tagsblogs::select('name','id')->get();
        return response()->json(
            [
                'total' =>count( $tags ),
                'data' => $tags ,
                '_benchmark' => microtime(true) -  $this->time_start,

            ],
            200
        );

    }


    public function search()
    {

        $news = News::select('slug', 'title', 'id', 'image')->get();
        foreach ($news  as $key => $value) {
            $news[$key]['user'] = false;
            $news[$key]['page'] = '/news/';
            $news[$key]['icon'] = 'mdi-newspaper-variant-multiple-outline';
            $news[$key]['image'] =  ($value['image'])? url($value['image']): null;
        }

        $post = Post::select('slug', 'title', 'id', 'image')->get();
        foreach ($post  as $key => $value) {
            $post[$key]['user'] = false;
            $post[$key]['page'] = '/post/';
            $post[$key]['icon'] = 'mdi-post-outline';
            $post[$key]['image'] = ($value['image'])? url($value['image']): null;
        }

        $blog = Blog::select('slug', 'title', 'id', 'image')->get();
        foreach ($blog as $key => $value) {
            $blog[$key]['user'] = false;
            $blog[$key]['page'] = '/blog/';
            $blog[$key]['icon'] = 'mdi-blogger';
            $blog[$key]['image'] =  ($value['image'])? url($value['image']): null;
        }

        $userdetails = UserDetails::select('username', 'id', 'profile_picture')->whereNotNull('username')->get();

        foreach ($userdetails as $key => $value) {
            $userdetails[$key]['user'] = true;
            $userdetails[$key]['title'] = $value['username'];
            $userdetails[$key]['slug'] = $value['username'];
            $userdetails[$key]['page'] = '/';
            $userdetails[$key]['icon'] = 'mdi-card-account-details-outline';
            $userdetails[$key]['image'] = filter_var($value['profile_picture'], FILTER_VALIDATE_URL) ? $value['profile_picture'] : (($value['profile_picture'])? url($value['profile_picture']):null);
        }

        //merge

        foreach ($news as $newssingle) {
            $post->add($newssingle);
        }

        foreach ($post as $postsingle) {
            $blog->add($postsingle);
        }

        foreach ($blog as $blogsingle) {
            $userdetails->add($blogsingle);
        }


        $results = $userdetails;

        return response()->json(
            [
                'count' => count($results),
                'entries' =>   $results,
                '_benchmark' => microtime(true) -  $this->time_start,
            ],
            200
        );
    }
}

