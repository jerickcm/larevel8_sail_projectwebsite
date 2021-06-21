<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tagsblogs;
class Tagsblogs_blogs extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    protected $fillable = ['blog_id','tagsblogs_id'];
    protected $table = "tagsblogs_blogs";
    public $timestamps = true;

    public function tagger()
    {
        return $this->hasMany(Tagsblogs::class,'id','tagsblogs_id');
    }

}
