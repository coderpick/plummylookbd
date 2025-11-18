<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded =['id'];

    public function getRouteKeyName(){
        return 'slug';
    }
    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
