<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $guarded =['id'];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function scopePublished($query)
    {
        return $query->where('status','published');
    }

    public function postTags()
    {
        return $this->hasMany(PostTag::class);
    }

}
