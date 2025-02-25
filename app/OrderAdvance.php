<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdvance extends Model
{
    protected $guarded =['id'];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
