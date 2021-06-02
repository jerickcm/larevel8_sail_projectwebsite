<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Ckeditorupload extends Model
{
    use HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'user_id','user_id','image_name','instance_identifier'
    ];
}
