<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Photo extends Model
{
    use HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'path',
    ];

    public function imageable(){

        return $this->morphTo();
    }
}
