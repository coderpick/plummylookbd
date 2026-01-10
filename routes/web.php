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

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FlashController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderAdvanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController as FrontendPageController;
use App\Http\Controllers\PathaoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SinglePageController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StaticReviewController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Vendor\CategoryController as VendorCategoryController;
use App\Http\Controllers\Vendor\ShopController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\WithdrawController;
use App\Http\Controllers\VoucherController;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
 =======================
    Frontend Routes
==========================
 */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/details/{slug}', [HomeController::class, 'details'])->name('product.details');
Route::get('/category/{slug?}', [HomeController::class, 'category'])->name('product.category');
Route::get('/tag/{slug}', [HomeController::class, 'tagProduct'])->name('tag_product');
Route::get('/sale', [HomeController::class, 'sale'])->name('product.sale');
Route::get('/sub-category/{slug}', [HomeController::class, 'subcategory'])->name('product.subcategory');
Route::get('/brands/{slug?}', [HomeController::class, 'brand'])->name('product.brand');
Route::get('/concern/{slug}', [HomeController::class, 'concern'])->name('product.concern');
Route::get('/featured', [HomeController::class, 'featured'])->name('product.featured_sale');
// Route::get('/new-arrivals', 'HomeController@new_arrival')->name('product.new_arrival');
// Route::get('/best-selling', 'HomeController@best_selling')->name('product.best_selling');
Route::get('/flash-sale', [HomeController::class, 'flash'])->name('product.flash_sale');
Route::get('/announcement', [HomeController::class, 'offer'])->name('offer');
Route::get('search', [HomeController::class, 'find'])->name('product.find');
Route::get('products/{key}/short-by/{by}', [HomeController::class, 'short'])->name('product.short');
Route::get('product/{key}/short-by/{by}', [HomeController::class, 'subshort'])->name('product.subshort');
// Route::get('become-seller', 'HomeController@seller')->name('seller');
Route::get('search-autocomplete', [HomeController::class, 'searchAutoComplete'])->name('search.autocomplete');

Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('blog/category/{categorySlug}', [BlogController::class, 'categoryPost'])->name('blog.category.post');
Route::get('blog/tag/{tagSlug}', [BlogController::class, 'tagPost'])->name('blog.tag.post');

// add to cart route
Route::get('ajax/add-to-cart/{product_id}', [AjaxController::class, 'addToCart'])->name('ajax.addToCart');
Route::get('remove-cart/{product_id}', [AjaxController::class, 'delete'])->name('remove.cart');
Route::post('update-cart', [AjaxController::class, 'update'])->name('update.cart');
Route::post('add-cart/{product_id}', [AjaxController::class, 'add'])->name('add.cart');

// cart view routes
Route::get('cart', [CheckoutController::class, 'cart'])->name('cart');
Route::get('clear', [CheckoutController::class, 'clear'])->name('clear.cart');

// favourite routes
Route::post('add-fav/{product_id}', [FavouriteController::class, 'add'])->name('add.fav');
Route::post('rmv-fav/{product_id}', [FavouriteController::class, 'remove'])->name('remove.fav');
Route::post('clr-fav/{id}', [FavouriteController::class, 'clear'])->name('clear.fav');

// facebook routes
/*Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('fb.login');
Route::get('login/facebook/call-back', 'Auth\LoginController@handleProviderCallback');*/

// user Auth routes
Route::middleware(['auth', 'verified'])->group(function () {

    // SSLCOMMERZ Start
    Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
    // Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);
    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
    // Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
    // SSLCOMMERZ END

    // review routes
    Route::post('submit-review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('advance-pay', [OrderAdvanceController::class, 'store'])->name('advance.store');

    // favourite route
    Route::get('favourites', [FavouriteController::class, 'index'])->name('favourite');
    Route::get('add-favourite/{product_id}', [FavouriteController::class, 'store'])->name('add.favourite');

    // Front user routes
    Route::get('my-dashboard', [CustomerController::class, 'index'])->name('account');
    Route::get('profile-info', [CustomerController::class, 'show'])->name('customer.show');
    Route::put('account/{slug}', [CustomerController::class, 'update'])->name('user.info.update');

    Route::get('payment/{slug}/{orderId}', [CheckoutController::class, 'payment'])->name('payment');
    Route::get('discount/{id}', [VoucherController::class, 'discount'])->name('discount');

    // user order n track
    Route::get('my-orders', [OrderController::class, 'myorder'])->name('myorders');
    Route::get('my-orders/details/{id}', [OrderController::class, 'myorder_details'])->name('myorder.show');
    Route::get('track/{slug}/{orderId}', [OrderController::class, 'track'])->name('track');

    // dispute routes
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

    Route::post('cancel-order/{id}/customer/{status}', [OrderController::class, 'cancel'])->name('cancel.order');

    // Route::get('my-reviews','ReviewController@reviews')->name('my_reviews');

});
// session coupon apply
Route::get('coupon-apply', [VoucherController::class, 'coupon_apply'])->name('coupon_apply');

Route::get('buy-now/{slug}', [CheckoutController::class, 'buy'])->name('buy_now');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('order/place', [CustomerController::class, 'store'])->name('order.place');

// Subscribe us
Route::post('subscribe', [SubscribeController::class, 'store'])->name('subscribe.us');
// Route::get('unsubscribe','SubscribeController@create')->name('unsubscribe');
// Route::post('unsubscribe','SubscribeController@unsubscribe')->name('unsubscribe.us');
// contact us
Route::post('contact', [SubscribeController::class, 'contact_us'])->name('contact.us');

Route::get('contact-us', [SinglePageController::class, 'contact'])->name('contact');
Route::get('cookies-policy', [SinglePageController::class, 'cookies'])->name('cookies');

// Vendor Routes
// Route::get('merchant-register','Vendor\VendorController@create')->name('vendor.create');
Route::post('vendor-store', [VendorController::class, 'store'])->name('vendor.store');

Route::get('/store/{slug}', [VendorController::class, 'shop_product'])->name('merchant.product');
Route::get('/stores', [VendorController::class, 'vendors_shop'])->name('merchant.shop');

Route::get('categories', [CategoryController::class, 'categories'])->name('front.category');

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

Route::middleware(['auth', 'verified', 'admin', 'web'])->prefix('secure')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('report', [OrderAdvanceController::class, 'report_create'])->name('report.create');
    Route::post('report-generate', [OrderAdvanceController::class, 'report_store'])->name('report.store');

    // review routes
    Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');
    Route::get('review-pending', [ReviewController::class, 'pending'])->name('review.pending');
    Route::get('review-product/{slug}', [ReviewController::class, 'product'])->name('review.product');
    Route::get('review-user/{slug}', [ReviewController::class, 'user'])->name('review.user');
    Route::post('review-approve/{id}', [ReviewController::class, 'approve'])->name('review.approve');
    Route::delete('review-delete/{id}', [ReviewController::class, 'destroy'])->name('review.delete');

    // flash routes
    Route::get('flash-products', [FlashController::class, 'index'])->name('flash.index');
    Route::post('flash', [FlashController::class, 'store'])->name('flash.store');
    Route::get('flash-products/create', [FlashController::class, 'create'])->name('flash.create');
    Route::get('flash-update/{id}', [FlashController::class, 'update'])->name('flash.update');
    Route::get('flash-destroy/{id}', [FlashController::class, 'destroy'])->name('flash.destroy');

    // category routes
    Route::resource('category', CategoryController::class);
    Route::post('category/{id}/restore', [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');

    // sub-category routes
    Route::resource('sub-category', SubCategoryController::class);
    Route::post('sub-category/{id}/restore', [SubCategoryController::class, 'restore'])->name('sub-category.restore');
    Route::delete('sub-category/{id}/delete', [SubCategoryController::class, 'delete'])->name('sub-category.delete');
    Route::get('ajax/sub_category', [SubCategoryController::class, 'subcategories'])->name('ajax.subcategory');

    // brand routes
    Route::resource('brand', BrandController::class);
    Route::post('brand/{id}/restore', [BrandController::class, 'restore'])->name('brand.restore');
    Route::delete('brand/{id}/delete', [BrandController::class, 'delete'])->name('brand.delete');

    // concern routes
    Route::resource('concern', ConcernController::class);
    Route::post('concern/{id}/restore', [ConcernController::class, 'restore'])->name('concern.restore');
    Route::delete('concern/{id}/delete', [ConcernController::class, 'delete'])->name('concern.delete');

    /* tag route */
    Route::get('tag', [TagController::class, 'index'])->name('tag.index');
    Route::post('tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::get('tag/edit', [TagController::class, 'edit'])->name('tag.edit');
    Route::post('tag/update', [TagController::class, 'update'])->name('tag.update');
    Route::post('tag/destroy/{id}', [TagController::class, 'destroy'])->name('tag.destroy');
    /* blog category */
    Route::get('blog_category', [BlogCategoryController::class, 'index'])->name('blog_category.index');
    Route::post('blog_category/store', [BlogCategoryController::class, 'store'])->name('blog_category.store');
    Route::get('blog_category/edit', [BlogCategoryController::class, 'edit'])->name('blog_category.edit');
    Route::post('blog_category/update', [BlogCategoryController::class, 'update'])->name('blog_category.update');
    Route::post('blog_category/destroy/{id}', [BlogCategoryController::class, 'destroy'])->name('blog_category.destroy');
    /* post route */
    Route::resource('post', PostController::class);
    Route::post('post/trash/{id}', [PostController::class, 'trash'])->name('post.trash');
    Route::get('post/restore/{id}', [PostController::class, 'restore'])->name('post.restore');

    // voucher routes
    Route::resource('coupon', VoucherController::class);
    Route::post('coupon/{id}/restore', [VoucherController::class, 'restore'])->name('coupon.restore');
    Route::delete('coupon/{id}/delete', [VoucherController::class, 'delete'])->name('coupon.delete');

    // ready review routes
    Route::resource('static-review', StaticReviewController::class);

    // Offer routes
    Route::resource('offer', OfferController::class);
    Route::post('offer/{id}/restore', [OfferController::class, 'restore'])->name('offer.restore');
    Route::delete('offer/{id}/delete', [OfferController::class, 'delete'])->name('offer.delete');

    // product routes
    Route::resource('product', ProductController::class);
    Route::post('product/{id}/restore', [ProductController::class, 'restore'])->name('product.restore');
    Route::delete('product/{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::get('product/{image_id}/delete', [ProductController::class, 'delete_image'])->name('product.delete.image');
    Route::get('products/featured', [ProductController::class, 'featured'])->name('product.featured');
    // Route::get('products/flash-sale','ProductController@flash')->name('product.flash');
    Route::post('product-apply-multiple', [ProductController::class, 'apply_multiple'])->name('applyMultiple');

    // Order manage routes
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}/details', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('orders/{order_id}/change-status/{status}', [OrderController::class, 'change_status'])->name('changeStatus');
    Route::post('order-detail/{id}/change-detail/{detail}', [OrderController::class, 'change_detail'])->name('changeDetail');
    Route::post('order-multiple', [OrderController::class, 'change_multiple'])->name('changeMultiple');

    Route::get('orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('orders/confirmed', [OrderController::class, 'confirmed'])->name('orders.confirmed');
    Route::get('orders/processing', [OrderController::class, 'processing'])->name('orders.processing');
    Route::get('orders/shipped', [OrderController::class, 'shipped'])->name('orders.shipped');
    Route::get('orders/delivered', [OrderController::class, 'delivered'])->name('orders.delivered');
    Route::get('orders/canceled', [OrderController::class, 'canceled'])->name('orders.canceled');

    Route::get('orders/{slug}', [OrderController::class, 'customer'])->name('orders.customer');

    /* Unauthorized page */
    Route::get('error', function () {
        return view('back.unauthorized');
    })->name('unauthorized.page');

    /* Role Routes */
    Route::resource('roles', RoleController::class);

    // Admin Routes
    Route::resource('user', UserController::class);
    Route::get('user/{slug}/edit', [UserController::class, 'edit'])->name('user.profile_edit');
    Route::post('user/{slug}/edit', [UserController::class, 'profile_update'])->name('user.profile_update');
    Route::post('user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    Route::delete('user/{id}/trash', [UserController::class, 'trash'])->name('user.trash');
    Route::get('profile', [UserController::class, 'show'])->name('user.info');
    Route::get('customer/{id}/details', [UserController::class, 'details'])->name('user.details');

    // Customer list Route
    Route::get('customers', [UserController::class, 'customer'])->name('customer');
    Route::post('customer/{id}/restore', [UserController::class, 'customer_restore'])->name('customer.restore');
    Route::delete('customer/{user}/destroy', [UserController::class, 'customer_destroy'])->name('customer.destroy');

    // Subscriber List route
    Route::get('subscribers', [SubscribeController::class, 'index'])->name('subscribers');
    Route::delete('subscribers/{id}/delete', [SubscribeController::class, 'destroy'])->name('subscriber.destroy');
    Route::get('scr/queue', [SubscribeController::class, 'queue'])->name('queue');
    Route::post('newsletter', [SubscribeController::class, 'newsletter'])->name('newsletter');
    Route::get('searches', [SubscribeController::class, 'searches'])->name('searches');
    Route::get('customer-click', [SubscribeController::class, 'customer_click'])->name('customer_click');

    // Slider routes
    Route::get('flash-banner', [ContentController::class, 'banner_image'])->name('banner.index');
    Route::patch('setting/banner', [ContentController::class, 'banner_imageUpdate'])->name('banner.update');

    // Slider routes
    Route::resource('setting/slider', SliderController::class);
    Route::post('setting/slider/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
    Route::delete('setting/slider/{id}/delete', [SliderController::class, 'delete'])->name('slider.delete');

    // shipping routes
    route::group(['prefix' => 'setting/shipping'], function () {
        Route::get('/', [ShippingController::class, 'index'])->name('shipping.index');
        Route::post('/store', [ShippingController::class, 'store'])->name('shipping.insert');
    });

    // contacts routes
    route::group(['prefix' => 'setting/contact'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/store', [ContactController::class, 'store'])->name('contact.insert');
    });

    Route::get('/pathao/cities', [PathaoController::class, 'cities']);
    Route::get('/pathao/zones/{cityId}', [PathaoController::class, 'zones']);
    Route::get('/pathao/areas/{zoneId}', [PathaoController::class, 'areas']);
    Route::get('/pathao/send/{order}', [PathaoController::class, 'showForm'])->name('pathao.form');
    Route::post('/pathao/order/{order}', [PathaoController::class, 'createOrder'])->name('pathao.send');

    // About routes
    route::group(['prefix' => 'setting'], function () {
        Route::resource('page', PageController::class);
    });

    // log and links routes
    route::group(['prefix' => 'setting/link'], function () {
        Route::get('/', [LinkController::class, 'index'])->name('link.index');
        Route::post('/store', [LinkController::class, 'store'])->name('link.insert');
    });

    // Privacy & Policy
    route::group(['prefix' => 'setting/privacy'], function () {
        Route::get('/', [PrivacyController::class, 'index'])->name('privacy.index');
        Route::post('/store', [PrivacyController::class, 'store'])->name('privacy.insert');
    });

    // meta routes
    route::group(['prefix' => 'setting/meta'], function () {
        Route::get('/', [MetaController::class, 'index'])->name('meta.index');
        Route::post('/store', [MetaController::class, 'store'])->name('meta.insert');
    });

    // disputes routes
    /* Route::get('dispute/reply/{id}','DisputeController@get')->name('dispute.get'); */ /* ajax get route routes */
    /*Route::get('disputes','DisputeController@index')->name('dispute.index');
    Route::get('disputes/closed','DisputeController@closed')->name('dispute.closed');
    Route::get('dispute/details/{id}','DisputeController@show')->name('dispute.show');
    Route::delete('dispute/{id}/destroy','DisputeController@destroy')->name('dispute.destroy');
    Route::post('dispute/{id}/restore','DisputeController@restore')->name('dispute.restore');*/
    /* Route::post('dispute/response','DisputeController@response')->name('dispute.response'); */

    // ticket routes
    /*Route::get('tickets','TicketController@index')->name('ticket.index');
    Route::get('tickets/closed','TicketController@closed')->name('ticket.closed');
    Route::get('ticket/details/{id}','TicketController@show')->name('ticket.show');
    Route::delete('ticket/{id}/destroy','TicketController@destroy')->name('ticket.destroy');
    Route::post('ticket/{id}/restore','TicketController@restore')->name('ticket.restore');*/

    // Vendor routes
    Route::get('vendors', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('vendor/create', [VendorController::class, 'create'])->name('vendor.create');
    Route::get('vendor/{id}/edit', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::post('vendor/{id}/update', [VendorController::class, 'vendor_update'])->name('vendor.update');
    Route::get('vendor/{id}/details', [VendorController::class, 'details'])->name('vendor.details');
    // Route::get('vendors/pending','Vendor\VendorController@pending')->name('vendor.pending');
    Route::get('vendors/blocked', [VendorController::class, 'blocked'])->name('vendor.blocked');
    Route::post('vendor/{id}/accept', [VendorController::class, 'accept'])->name('vendor.accept');
    Route::post('vendor/{id}/restore', [VendorController::class, 'restore'])->name('vendor.restore');
    Route::delete('vendor/{id}/destroy', [VendorController::class, 'destroy'])->name('vendor.destroy');
    Route::delete('vendor/{id}/delete', [VendorController::class, 'delete'])->name('vendor.delete');

    Route::get('vendor/{slug}/products', [VendorController::class, 'get_product'])->name('vendor.product');
    Route::get('vendor/{slug}/orders', [VendorController::class, 'get_order'])->name('vendor.order');

    // Vendor category routes
    Route::get('categories/pending', [VendorCategoryController::class, 'pending'])->name('category.pending');
    Route::post('categories/{id}/accept', [VendorCategoryController::class, 'accept'])->name('category.accept');
    Route::delete('categories/{id}/remove', [VendorCategoryController::class, 'delete'])->name('category.remove');

    // Vendor user routes
    Route::get('store', [VendorController::class, 'shop'])->name('vendor.shop');
    Route::put('shop/update/{id}', [VendorController::class, 'update'])->name('shop.update');

    Route::post('vendor/{id}/commission', [ShopController::class, 'commission'])->name('vendor.commission');

    // withdraw route
    Route::get('withdraws', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::get('withdraw-shop/{slug}', [WithdrawController::class, 'single'])->name('withdraw.single');
    Route::get('withdraws/pending', [WithdrawController::class, 'pending'])->name('withdraw.pending');
    Route::get('withdraws/processing', [WithdrawController::class, 'processing'])->name('withdraw.processing');
    Route::get('withdraws/completed', [WithdrawController::class, 'completed'])->name('withdraw.completed');
    Route::get('withdraws/rejected', [WithdrawController::class, 'rejected'])->name('withdraw.rejected');
    Route::post('withdraws/{id}/change-status/{status}', [WithdrawController::class, 'change_status'])->name('withdraw.status');

    Route::post('withdraw/{id}/restore', [WithdrawController::class, 'restore'])->name('withdraw.restore');
    Route::delete('withdraw/{id}/destroy', [WithdrawController::class, 'destroy'])->name('withdraw.destroy');

    Route::get('withdraw/create', [WithdrawController::class, 'create'])->name('withdraw.create');
    Route::post('withdraw/store', [WithdrawController::class, 'store'])->name('withdraw.store');
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

/* page route */
Route::get('/{slug}', FrontendPageController::class)->name('static.page.show');
