<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EarthReminders extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "earthreminders";
    public $timestamps = true;
    protected $fillable = [
        'event_date', 'author', 'country', 'subtitle', 'ckeditor_log', 'title', 'content', 'user_id', 'name', 'slug', 'video', 'image', 'publish', 'publish_text'
    ];
}
