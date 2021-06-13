<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Quotes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "quotes";
    public $timestamps = true;
    protected $fillable = [
        'ckeditor_log','title', 'content', 'user_id', 'name', 'slug', 'video', 'image', 'publish', 'publish_text', 'author', 'message'
    ];


}
