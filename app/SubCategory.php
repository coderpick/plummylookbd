<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $guarded =['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
