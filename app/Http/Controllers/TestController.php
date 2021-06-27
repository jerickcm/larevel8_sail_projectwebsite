<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tagsblogs;
use App\Models\Blog;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use App\Models\Tagsblogs_blogs;

class TestController extends Controller
{

    public function testtest()
    {

        $Blogs = Blog::join('users', 'users.id', '=', 'blogs.user_id')
            ->select('users.name', 'users.email', 'blogs.id', 'blogs.title', 'blogs.content', 'blogs.slug', 'blogs.id', 'blogs.publish', 'blogs.image', 'blogs.created_at', 'blogs.ckeditor_log')
            ->limit(10)
            ->offset((1 - 1) * 10)
            ->take(10)
            ->get();

        foreach ($Blogs as $key => $value) {
            $Blogs[$key]['tags'][0] = null;
            $blog = Blog::find($value['id']);
            foreach ($blog->tagsblogs as $keys =>  $tags) {
                $Blogs[$key]['tags'][$keys]  = $tags->name;
            }
        }

        return response()->json([
            'data' => $Blogs,
            '_benchmark' => microtime(true) -  $this->time_start,
        ], 200);
    }
    public function tag_to_blog()
    {
        $Tagblogs = Tagsblogs::where('name', 'aaa');
        // dd($Tagblogs);
        dd($Tagblogs->blogs);
    }

    public function testpivot1()
    {
        $blogs = Blog::find(51);
        dd($blogs->tagsblogs);
    }

    public function testpivot2()
    {
        $blogs = Blog::find(53);
        $request = $blogs->tagsblogs()->where('tagsblogs_blogs.deleted_at', null)->get();

        foreach ($request as $keys =>  $tags) {
            echo $tags->name;
        }
    }



    public function qre()
    {
        $blogs = Blog::join('tagsblogs_blogs', 'tagsblogs_blogs.blog_id', '=', 'blogs.id')
            ->join('tagsblogs', 'tagsblogs.id', '=', 'tagsblogs_blogs.tagsblogs_id')
            ->where('tagsblogs.id', 4)
            ->select('tagsblogs.name', 'blogs.id')
            // ->limit(2)
            ->get();
        dd($blogs);
    }
}
