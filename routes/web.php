<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PathaoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;


/*
 =======================
    Frontend Routes
==========================
 */

Route::get('/', 'HomeController@index')->name('home');
Route::get('/details/{slug}', 'HomeController@details')->name('product.details');
Route::get('/category/{slug?}', 'HomeController@category')->name('product.category');
Route::get('/sale', 'HomeController@sale')->name('product.sale');
Route::get('/sub-category/{slug}', 'HomeController@subcategory')->name('product.subcategory');
Route::get('/brands/{slug?}', 'HomeController@brand')->name('product.brand');
Route::get('/concern/{slug}', 'HomeController@concern')->name('product.concern');
Route::get('/featured', 'HomeController@featured')->name('product.featured_sale');
//Route::get('/new-arrivals', 'HomeController@new_arrival')->name('product.new_arrival');
//Route::get('/best-selling', 'HomeController@best_selling')->name('product.best_selling');
Route::get('/flash-sale', 'HomeController@flash')->name('product.flash_sale');
Route::get('/announcement', 'HomeController@offer')->name('offer');
Route::get('search','HomeController@find')->name('product.find');
Route::get('products/{key}/short-by/{by}','HomeController@short')->name('product.short');
Route::get('product/{key}/short-by/{by}','HomeController@subshort')->name('product.subshort');
//Route::get('become-seller', 'HomeController@seller')->name('seller');
Route::get('search-autocomplete', 'HomeController@searchAutoComplete')->name('search.autocomplete');

Route::get('blog', 'BlogController@index')->name('blog.index');
Route::get('blog/{slug}', 'BlogController@show')->name('blog.show');
Route::get('blog/category/{slug}', 'BlogController@tag')->name('blog.tag');

//add to cart route
Route::get('ajax/add-to-cart/{product_id}','AjaxController@addToCart')->name('ajax.addToCart');
Route::get('remove-cart/{product_id}','AjaxController@delete')->name('remove.cart');
Route::post('update-cart','AjaxController@update')->name('update.cart');
Route::post('add-cart/{product_id}','AjaxController@add')->name('add.cart');

//cart view routes
Route::get('cart','CheckoutController@cart')->name('cart');
Route::get('clear','CheckoutController@clear')->name('clear.cart');

//favourite routes
Route::post('add-fav/{product_id}','FavouriteController@add')->name('add.fav');
Route::post('rmv-fav/{product_id}','FavouriteController@remove')->name('remove.fav');
Route::post('clr-fav/{id}','FavouriteController@clear')->name('clear.fav');

//facebook routes
/*Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('fb.login');
Route::get('login/facebook/call-back', 'Auth\LoginController@handleProviderCallback');*/

//user Auth routes
Route::middleware(['auth','verified'])->group(function (){

    // SSLCOMMERZ Start
    Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
    //Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);
    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
    //Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
    //SSLCOMMERZ END


    //review routes
    Route::post('submit-review', 'ReviewController@store')->name('review.store');
    Route::post('advance-pay', 'OrderAdvanceController@store')->name('advance.store');



    //favourite route
    Route::get('favourites','FavouriteController@index')->name('favourite');
    Route::get('add-favourite/{product_id}','FavouriteController@store')->name('add.favourite');

    //Front user routes
    Route::get('my-dashboard', 'CustomerController@index')->name('account');
    Route::get('profile-info', 'CustomerController@show')->name('customer.show');
    Route::put('account/{slug}','CustomerController@update')->name('user.info.update');


    Route::get('payment/{slug}/{orderId}','CheckoutController@payment')->name('payment');
    Route::get('discount/{id}', 'VoucherController@discount')->name('discount');

    //user order n track
    Route::get('my-orders','OrderController@myorder')->name('myorders');
    Route::get('my-orders/details/{id}','OrderController@myorder_details')->name('myorder.show');
    Route::get('track/{slug}/{orderId}','OrderController@track')->name('track');



    //dispute routes
//    Route::get('dispute/reply/{id}','DisputeController@get')->name('dispute.get'); /*ajax get route routes*/
//    Route::post('dispute/response','DisputeController@response')->name('dispute.response');
//
//    Route::get('my-returns','DisputeController@disputes')->name('my_disputes');
//    Route::post('my-disputes/store','DisputeController@store')->name('my_disputes.store');
//    Route::get('my-returns/{id}/details','DisputeController@details')->name('my_disputes.show');
//    Route::post('dispute/{id}/reply','DisputeController@reply')->name('dispute.reply');
//
//    //support ticket routes
//    Route::get('ticket/reply/{id}','TicketController@get')->name('ticket.get'); /*ajax get route routes*/
//    Route::post('ticket/response','TicketController@response')->name('ticket.response');
//
//    Route::get('my-tickets','TicketController@tickets')->name('my_tickets');
//    Route::post('my-tickets/store','TicketController@store')->name('my_tickets.store');
//    Route::get('my-tickets/{id}/details','TicketController@details')->name('my_tickets.show');
//    Route::post('ticket/{id}/reply','TicketController@reply')->name('ticket.reply');
//
//    Route::post('point/{id}/pay','PointController@point_pay')->name('point.pay');

    Route::post('cancel-order/{id}/customer/{status}','OrderController@cancel')->name('cancel.order');

    //Route::get('my-reviews','ReviewController@reviews')->name('my_reviews');

});
//session coupon apply
Route::get('coupon-apply', 'VoucherController@coupon_apply')->name('coupon_apply');

Route::get('buy-now/{slug}','CheckoutController@buy')->name('buy_now');
Route::get('checkout','CheckoutController@index')->name('checkout');
Route::post('order/place','CustomerController@store')->name('order.place');

//Subscribe us
Route::post('subscribe','SubscribeController@store')->name('subscribe.us');
//Route::get('unsubscribe','SubscribeController@create')->name('unsubscribe');
//Route::post('unsubscribe','SubscribeController@unsubscribe')->name('unsubscribe.us');
//contact us
Route::post('contact','SubscribeController@contact_us')->name('contact.us');

Route::get('contact-us','SinglePageController@contact')->name('contact');
Route::get('privacy-policy','SinglePageController@privacy')->name('privacy');
Route::get('cookies-policy','SinglePageController@cookies')->name('cookies');
Route::get('terms-and-condition','SinglePageController@terms')->name('terms');
Route::get('faq','SinglePageController@faq')->name('faq');

//Vendor Routes
//Route::get('merchant-register','Vendor\VendorController@create')->name('vendor.create');
Route::post('vendor-store','Vendor\VendorController@store')->name('vendor.store');

Route::get('/store/{slug}', 'Vendor\VendorController@shop_product')->name('merchant.product');
Route::get('/stores', 'Vendor\VendorController@vendors_shop')->name('merchant.shop');

Route::get('categories', 'CategoryController@categories')->name('front.category');

/*
 =======================
    Frontend Routes end
==========================
 */


/*
 =======================
    Dashboard Routes
==========================
 */

Route::middleware(['auth','verified','admin','web'])->prefix('secure')->group(function (){
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('report', 'OrderAdvanceController@report_create')->name('report.create');
    Route::post('report-generate', 'OrderAdvanceController@report_store')->name('report.store');

//review routes
    Route::get('reviews','ReviewController@index')->name('review.index');
    Route::get('review-pending','ReviewController@pending')->name('review.pending');
    Route::get('review-product/{slug}','ReviewController@product')->name('review.product');
    Route::get('review-user/{slug}','ReviewController@user')->name('review.user');
    Route::post('review-approve/{id}','ReviewController@approve')->name('review.approve');
    Route::delete('review-delete/{id}','ReviewController@destroy')->name('review.delete');

//flash routes
Route::get('flash-products','FlashController@index')->name('flash.index');
Route::post('flash','FlashController@store')->name('flash.store');
Route::get('flash-products/create','FlashController@create')->name('flash.create');
Route::get('flash-update/{id}','FlashController@update')->name('flash.update');
Route::get('flash-destroy/{id}','FlashController@destroy')->name('flash.destroy');

//category routes
Route::resource('category', 'CategoryController');
Route::post('category/{id}/restore', 'CategoryController@restore')->name('category.restore');
Route::delete('category/{id}/delete', 'CategoryController@delete')->name('category.delete');

//sub-category routes
    Route::resource('sub-category', 'SubCategoryController');
    Route::post('sub-category/{id}/restore', 'SubCategoryController@restore')->name('sub-category.restore');
    Route::delete('sub-category/{id}/delete', 'SubCategoryController@delete')->name('sub-category.delete');
    Route::get('ajax/sub_category', 'SubCategoryController@subcategories')->name('ajax.subcategory');

//brand routes
Route::resource('brand', 'BrandController');
Route::post('brand/{id}/restore', 'BrandController@restore')->name('brand.restore');
Route::delete('brand/{id}/delete', 'BrandController@delete')->name('brand.delete');

//concern routes
Route::resource('concern', 'ConcernController');
Route::post('concern/{id}/restore', 'ConcernController@restore')->name('concern.restore');
Route::delete('concern/{id}/delete', 'ConcernController@delete')->name('concern.delete');

    /*tag route*/
    Route::get('tag', [TagController::class,'index'])->name('tag.index');
    Route::post('tag/store', [TagController::class,'store'])->name('tag.store');
    Route::get('tag/edit', [TagController::class,'edit'])->name('tag.edit');
    Route::post('tag/update', [TagController::class,'update'])->name('tag.update');
    Route::post('tag/destroy/{id}', [TagController::class,'destroy'])->name('tag.destroy');

    /*post route*/
    Route::resource('post',PostController::class);
    Route::post('post/trash/{id}',[PostController::class,'trash'])->name('post.trash');
    Route::get('post/restore/{id}',[PostController::class,'restore'])->name('post.restore');

//voucher routes
Route::resource('coupon', 'VoucherController');
Route::post('coupon/{id}/restore', 'VoucherController@restore')->name('coupon.restore');
Route::delete('coupon/{id}/delete', 'VoucherController@delete')->name('coupon.delete');

//ready review routes
Route::resource('static-review', 'StaticReviewController');

//Offer routes
    Route::resource('offer','OfferController');
    Route::post('offer/{id}/restore','OfferController@restore')->name('offer.restore');
    Route::delete('offer/{id}/delete','OfferController@delete')->name('offer.delete');

//product routes
Route::resource('product', 'ProductController');
Route::post('product/{id}/restore', 'ProductController@restore')->name('product.restore');
Route::delete('product/{id}/delete', 'ProductController@delete')->name('product.delete');
Route::get('product/{image_id}/delete','ProductController@delete_image')->name('product.delete.image');
Route::get('products/featured','ProductController@featured')->name('product.featured');
//Route::get('products/flash-sale','ProductController@flash')->name('product.flash');
Route::post('product-apply-multiple','ProductController@apply_multiple')->name('applyMultiple');


//Order manage routes
Route::get('orders','OrderController@index')->name('orders.index');
Route::get('orders/{id}/details','OrderController@show')->name('orders.show');
Route::get('orders/{id}/invoice','OrderController@invoice')->name('orders.invoice');
Route::get('orders/{id}/change-status/{status}','OrderController@change_status')->name('changeStatus');
Route::post('order-detail/{id}/change-detail/{detail}','OrderController@change_detail')->name('changeDetail');
Route::post('order-multiple','OrderController@change_multiple')->name('changeMultiple');

Route::get('orders/pending','OrderController@pending')->name('orders.pending');
Route::get('orders/confirmed','OrderController@confirmed')->name('orders.confirmed');
Route::get('orders/processing','OrderController@processing')->name('orders.processing');
Route::get('orders/shipped','OrderController@shipped')->name('orders.shipped');
Route::get('orders/delivered','OrderController@delivered')->name('orders.delivered');
Route::get('orders/canceled','OrderController@canceled')->name('orders.canceled');

Route::get('orders/{slug}','OrderController@customer')->name('orders.customer');

/*Unauthorized page*/
Route::get( 'error', function () {
    return view( 'back.unauthorized' );
} )->name( 'unauthorized.page' );

/*Role Routes*/
Route::resource('roles','RoleController');

//Admin Routes
Route::resource('user', 'UserController');
Route::get('user/{slug}/edit', 'UserController@edit')->name('user.profile_edit');
Route::post('user/{slug}/edit', 'UserController@profile_update')->name('user.profile_update');
Route::post('user/{id}/restore', 'UserController@restore')->name('user.restore');
Route::delete('user/{id}/trash', 'UserController@trash')->name('user.trash');
Route::get('profile', 'UserController@show')->name('user.info');
Route::get('customer/{id}/details', 'UserController@details')->name('user.details');

//Customer list Route
Route::get('customers', 'UserController@customer')->name('customer');
Route::post('customer/{id}/restore', 'UserController@customer_restore')->name('customer.restore');
Route::delete('customer/{user}/destroy', 'UserController@customer_destroy')->name('customer.destroy');

//Subscriber List route
Route::get('subscribers','SubscribeController@index')->name('subscribers');
Route::delete('subscribers/{id}/delete', 'SubscribeController@destroy')->name('subscriber.destroy');
Route::get('scr/queue','SubscribeController@queue')->name('queue');
Route::post('newsletter','SubscribeController@newsletter')->name('newsletter');
Route::get('searches','SubscribeController@searches')->name('searches');
Route::get('customer-click','SubscribeController@customer_click')->name('customer_click');

//Slider routes
    Route::get( 'flash-banner','ContentController@banner_image' )->name( 'banner.index' );
    Route::patch( 'setting/banner', 'ContentController@banner_imageUpdate' )->name( 'banner.update' );

//Slider routes
Route::resource('setting/slider','SliderController');
Route::post('setting/slider/{id}/restore','SliderController@restore')->name('slider.restore');
Route::delete('setting/slider/{id}/delete','SliderController@delete')->name('slider.delete');

//shipping routes
route::group(['prefix' => 'setting/shipping'], function () {
    Route::get('/', 'ShippingController@index')->name('shipping.index');
    Route::post('/store', 'ShippingController@store')->name('shipping.insert');
});

//contacts routes
    route::group(['prefix' => 'setting/contact'], function () {
        Route::get('/', 'ContactController@index')->name('contact.index');
        Route::post('/store', 'ContactController@store')->name('contact.insert');
    });

    Route::get('/pathao/cities', [PathaoController::class, 'cities']);
    Route::get('/pathao/zones/{cityId}', [PathaoController::class, 'zones']);
    Route::get('/pathao/areas/{zoneId}', [PathaoController::class, 'areas']);
    Route::get('/pathao/send/{order}', [PathaoController::class, 'showForm'])->name('pathao.form');
    Route::post('/pathao/order/{order}', [PathaoController::class, 'createOrder'])->name('pathao.send');

//About routes
//route::group(['prefix' => 'setting/about'], function () {
//    Route::get('/', 'AboutController@index')->name('about.index');
//    Route::post('/store', 'AboutController@store')->name('about.insert');
//});

//log and links routes
route::group(['prefix' => 'setting/link'], function () {
    Route::get('/', 'LinkController@index')->name('link.index');
    Route::post('/store', 'LinkController@store')->name('link.insert');
});


//Privacy & Policy
route::group(['prefix' => 'setting/privacy'], function () {
    Route::get('/', 'PrivacyController@index')->name('privacy.index');
    Route::post('/store', 'PrivacyController@store')->name('privacy.insert');
});

//meta routes
route::group(['prefix' => 'setting/meta'], function () {
    Route::get('/', 'MetaController@index')->name('meta.index');
    Route::post('/store', 'MetaController@store')->name('meta.insert');
});

//disputes routes
    /*Route::get('dispute/reply/{id}','DisputeController@get')->name('dispute.get');*/ /*ajax get route routes*/
/*Route::get('disputes','DisputeController@index')->name('dispute.index');
Route::get('disputes/closed','DisputeController@closed')->name('dispute.closed');
Route::get('dispute/details/{id}','DisputeController@show')->name('dispute.show');
Route::delete('dispute/{id}/destroy','DisputeController@destroy')->name('dispute.destroy');
Route::post('dispute/{id}/restore','DisputeController@restore')->name('dispute.restore');*/
/*Route::post('dispute/response','DisputeController@response')->name('dispute.response');*/


//ticket routes
/*Route::get('tickets','TicketController@index')->name('ticket.index');
Route::get('tickets/closed','TicketController@closed')->name('ticket.closed');
Route::get('ticket/details/{id}','TicketController@show')->name('ticket.show');
Route::delete('ticket/{id}/destroy','TicketController@destroy')->name('ticket.destroy');
Route::post('ticket/{id}/restore','TicketController@restore')->name('ticket.restore');*/


//Vendor routes
Route::get('vendors','Vendor\VendorController@index')->name('vendor.index');
Route::get('vendor/create','Vendor\VendorController@create')->name('vendor.create');
Route::get('vendor/{id}/edit','Vendor\VendorController@edit')->name('vendor.edit');
Route::post('vendor/{id}/update','Vendor\VendorController@vendor_update')->name('vendor.update');
Route::get('vendor/{id}/details', 'Vendor\VendorController@details')->name('vendor.details');
//Route::get('vendors/pending','Vendor\VendorController@pending')->name('vendor.pending');
Route::get('vendors/blocked','Vendor\VendorController@blocked')->name('vendor.blocked');
Route::post('vendor/{id}/accept', 'Vendor\VendorController@accept')->name('vendor.accept');
Route::post('vendor/{id}/restore', 'Vendor\VendorController@restore')->name('vendor.restore');
Route::delete('vendor/{id}/destroy', 'Vendor\VendorController@destroy')->name('vendor.destroy');
Route::delete('vendor/{id}/delete','Vendor\VendorController@delete')->name('vendor.delete');


Route::get('vendor/{slug}/products','Vendor\VendorController@get_product')->name('vendor.product');
Route::get('vendor/{slug}/orders','Vendor\VendorController@get_order')->name('vendor.order');

//Vendor category routes
Route::get('categories/pending','Vendor\CategoryController@pending')->name('category.pending');
Route::post('categories/{id}/accept','Vendor\CategoryController@accept')->name('category.accept');
Route::delete('categories/{id}/remove','Vendor\CategoryController@delete')->name('category.remove');

//Vendor user routes
    Route::get('store','Vendor\VendorController@shop')->name('vendor.shop');
    Route::put('shop/update/{id}','Vendor\VendorController@update')->name('shop.update');

    Route::post('vendor/{id}/commission', 'Vendor\ShopController@commission')->name('vendor.commission');


//withdraw route
    Route::get('withdraws', 'Vendor\WithdrawController@index')->name('withdraw.index');
    Route::get('withdraw-shop/{slug}', 'Vendor\WithdrawController@single')->name('withdraw.single');
    Route::get('withdraws/pending','Vendor\WithdrawController@pending')->name('withdraw.pending');
    Route::get('withdraws/processing','Vendor\WithdrawController@processing')->name('withdraw.processing');
    Route::get('withdraws/completed','Vendor\WithdrawController@completed')->name('withdraw.completed');
    Route::get('withdraws/rejected','Vendor\WithdrawController@rejected')->name('withdraw.rejected');
    Route::post('withdraws/{id}/change-status/{status}','Vendor\WithdrawController@change_status')->name('withdraw.status');

    Route::post('withdraw/{id}/restore', 'Vendor\WithdrawController@restore')->name('withdraw.restore');
    Route::delete('withdraw/{id}/destroy', 'Vendor\WithdrawController@destroy')->name('withdraw.destroy');

    Route::get('withdraw/create', 'Vendor\WithdrawController@create')->name('withdraw.create');
    Route::post('withdraw/store', 'Vendor\WithdrawController@store')->name('withdraw.store');
});

Auth::routes(['verify' => true]);


Route::get('/artisan-optimize', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->route('home');
});
Route::get('/artisan-seed', function () {
    Artisan::call('db:seed');
    return redirect()->route('home');
});

Route::get('/artisan-migrate', function () {
    Artisan::call('migrate');
    return redirect()->route('home');
});
