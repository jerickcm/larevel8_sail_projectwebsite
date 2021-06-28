<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tag;
use App\Models\Tagsblogs;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    protected $table = "blogs";
    public $timestamps = true;

    // protected $appends = [
    //     'description'
    // ];
    protected $appends = [
        'tagged',
    ];

    protected $fillable = [
        'ckeditor_log', 'title', 'content', 'user_id', 'name', 'slug', 'video', 'image', 'publish', 'publish_text'
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tagsblogs()
    {
        return $this->belongsToMany(Tagsblogs::class, 'tagsblogs_blogs', 'blog_id', 'tagsblogs_id');
    }

    public function getTaggedAttribute()
    {

        $this->attributes['tagged'][0] = null;
        $blog = Blog::find($this->attributes['id']);
        foreach ($blog->tagsblogs as $keys =>  $tags) {
            $this->attributes['tagged'][$keys]  = $tags->name;
        }

        return $this->attributes['tagged'];
    }
}
