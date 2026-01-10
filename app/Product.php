<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product_image()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function flash()
    {
        $date = Carbon::today()->toDateString();

        return $this->hasOne(Flash::class)->where('expires_at', '>=', $date)->orderBy('expires_at', 'ASC');
    }

    public function back_flash()
    {
        return $this->hasOne(Flash::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
