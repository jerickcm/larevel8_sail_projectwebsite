<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Taggable extends Model
{
    use HasFactory,SoftDeletes,Notifiable;

    protected $fillable = [
        'tag_id',
        'taggable_id',
        'taggable_type',
    ];

}
