<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
