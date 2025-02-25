<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispute extends Model
{
    use SoftDeletes;
    protected $guarded =['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reply()
    {
        return $this->hasMany(DisputeReply::class)->orderBy('id','ASC');
    }
}
