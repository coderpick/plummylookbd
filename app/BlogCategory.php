<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';

    protected $fillable = ['name', 'slug'];

    public function blog()
    {
        return $this->hasMany(Post::class, 'blog_category_id', 'id');
    }
}
