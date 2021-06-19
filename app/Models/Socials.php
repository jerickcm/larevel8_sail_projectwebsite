<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Socials extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "socials";

    public $timestamps = true;

    protected $fillable = [
        'name','user_id', 'social_id'
    ];

}
