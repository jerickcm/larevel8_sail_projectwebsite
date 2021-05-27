<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserDetails extends Model
{
    use HasFactory,SoftDeletes,Notifiable;

    protected $table = "user_details";

    protected $fillable = [
        'street','house_number','city','province','country','postcode','user_id'
    ];

}
