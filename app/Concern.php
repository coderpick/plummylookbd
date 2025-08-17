<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concern extends Model
{
    use SoftDeletes;
    protected $guarded =['id'];

    public function getRouteKeyName(){
        return 'slug';
    }
}
