<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag');
    }

    protected $casts = [
        'tag_for' => 'string',
    ];
}
