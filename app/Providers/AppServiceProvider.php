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
        view()->composer(['layouts/frontend/_header','layouts/frontend/_footer','layouts/frontend/_mobileMenu'], function ($view){
            $view->with('brands',Brand::orderBy('name','ASC')->get());
            $view->with('contact',Contact::latest()->first());
            $view->with('link',Link::latest()->first());
        });

        view()->composer('layouts/frontend/_head', function ($view){
            $view->with('meta',Meta::latest()->first());
        });

        view()->composer('layouts/frontend/_header', function ($view){
            $user = Auth::user();
            if (isset($user)){
                $view->with('favourite',Favourite::where('user_id',$user->id)->count());
            }
        });

        view()->composer('layouts/frontend/_mobileMenu', function ($view){
            $view->with('categories',Category::orderBy('name','ASC')->get());
        });
    }
}
