<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'division_id',
        'name',
        'bn_name',
        'lat',
        'lon',
        'url',
    ];
}
