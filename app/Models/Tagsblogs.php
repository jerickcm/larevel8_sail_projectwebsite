<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagsblogs extends Model
{

    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    protected $fillable = ['name'];
    protected $table = "tagsblogs";
    public $timestamps = true;


    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'tagsblogs_blogs',  'tagsblogs_id', 'blog_id');
    }
}
