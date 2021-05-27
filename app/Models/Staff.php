<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Photo;

class Staff extends Model
{
    use HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'name',
    ];


    public function photos(){

        return $this->morphMany(Photo::class,'imageable');
        // return $this->morphMany('App\Models\Photo');
    }


}
