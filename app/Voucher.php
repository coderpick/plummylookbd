<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;
    protected $guarded =['id'];

    public function getRouteKeyName(){
        return 'slug';
    }
}
