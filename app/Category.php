<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded =['id'];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function product()
    {
       return $this->hasMany(Product::class)->latest()->limit(16);

        /*return $this->hasMany(Product::class)->withCount('order_detail')
            ->orderBy('order_detail_count', 'DESC')->inRandomOrder();*/
    }

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
