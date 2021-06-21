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
    protected $fillable = [
        'ckeditor_log', 'title', 'content', 'user_id', 'name', 'slug', 'video', 'image', 'publish', 'publish_text'
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tagsblogs()
    {
        return $this->belongsToMany(Tagsblogs::class, 'tagsblogs_blogs','blog_id', 'tagsblogs_id' )->withoutTrashed();
    }
}
