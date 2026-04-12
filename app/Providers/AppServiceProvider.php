<?php

namespace App\Providers;

use App\Brand;
use App\Category;
use App\Contact;
use App\Favourite;
use App\Link;
use App\Meta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $sharedComposer = function ($view) {
            static $brands, $footer_brands, $contact, $link, $categories, $meta;

            if (!$brands) {
                $brands = Brand::orderBy('name','ASC')->get();
                $footer_brands = Brand::latest()->limit(5)->get();
                $contact = Contact::latest()->first();
                $link = Link::latest()->first();
                $categories = Category::orderBy('name','ASC')->get();
                $meta = Meta::latest()->first();
            }

            $view->with('brands', $brands);
            $view->with('footer_brands', $footer_brands);
            $view->with('contact', $contact);
            $view->with('link', $link);
            $view->with('categories', $categories);
            $view->with('meta', $meta);
        };

        view()->composer([
            'layouts/frontend/_header',
            'layouts/frontend/_footer',
            'layouts/frontend/_mobileMenu',
            'layouts/frontend/_head',
            'layouts/frontend/_meta'
        ], $sharedComposer);

        view()->composer('layouts/frontend/_header', function ($view){
            $user = Auth::user();
            if (isset($user)){
                $view->with('favourite',Favourite::where('user_id',$user->id)->count());
            }
        });
    }
}
