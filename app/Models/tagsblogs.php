<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Blog;

class Tagsblogs extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tagsblogs";
    public $timestamps = true;

    protected $fillable = [
        'name'
    ];


    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'tagsblogs_blogs', 'blog_id', 'tagsblogs_id');
    }
}
