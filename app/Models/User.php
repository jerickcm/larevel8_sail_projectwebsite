<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserDetails;
use App\Models\Posts;
use App\Models\Role;
use App\Models\Quotes;
use App\Models\EarthReminders;
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userdetails()
    {

        return $this->hasOne(UserDetails::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
    public function quotes()
    {
        return $this->hasMany(Quotes::class);
    }

    public function earthreminders()
    {
        return $this->hasMany(EarthReminders::class);
    }

    public function roles()
    {

        return $this->belongsToMany(Role::class);
    }

    public function messageoftheday()
    {

        return $this->hasMany(Post::class);
    }
}
