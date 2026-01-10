<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Concern;
use App\Offer;
use App\Product;
use App\Review;
use App\Search;
use App\Shop;
use App\Slider;
use App\SubCategory;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {

        $data['category_product'] = Category::select('id', 'name', 'slug', 'icon', 'banner', 'home_view')
            ->with(['product' => function ($q) {
                $q->with(['reviews', 'flash', 'product_image:product_id,file_path'])
                    ->where('status', 'active')
                    ->where('stock', '>', 0)
                    ->inRandomOrder();
            }])
            ->where('home_view', 1)
            ->orderBy('name', 'ASC')
            ->get()
            ->map(function ($category) {
                $category->setRelation('product', $category->product->take(4));

                return $category;
            });

        // $data['category_product'] = Shop::with('product','product.product_image:product_id,file_path')->orderBy('sequence','ASC')->get();

        /*$products = Product::latest()->where('status', 'active')->get();
        $data['products'] = $products->groupBy('category_id');*/

        $data['featured_product'] = Product::select('id', 'name', 'slug', 'price', 'new_price', 'stock')
            ->with(['reviews', 'product_image:product_id,file_path'])
            ->where('is_featured', 1)
            ->where('status', 'active')->inRandomOrder()->limit(8)->get();

        $data['flash_sale'] = Product::with(['category', 'brand', 'flash', 'reviews'])
            ->whereHas('flash', function ($q) {
                $date = Carbon::today()->toDateString();
                $q->where('flash_stock', '>', 0)->orderBy('expires_at', 'ASC');
            })->where('stock', '>', 0)->where('status', 'active')->inRandomOrder()->limit(12)->get();

        $data['sliders'] = Slider::orderBy('id', 'DESC')->get();

        // data for countdown
        $now = Carbon::now();
        $data['tomorrow'] = $now->addDays(1)->toDateString();
        $data['categories'] = Category::where('home_view', 0)->select('id', 'name', 'slug', 'icon')->orderBy('id', 'DESC')->get();
        $data['home_categories'] = Category::where('home_view', 1)->select('id', 'name', 'slug', 'icon')->orderBy('id', 'DESC')->limit(8)->get();
        $data['concerns'] = Concern::select('id', 'name', 'slug', 'icon')->orderBy('id', 'DESC')->get();
        $data['brands'] = Brand::select('id', 'name', 'slug', 'icon')->where('published_to_web', true)->orderBy('name', 'ASC')->get();

        return view('front.home', $data);
    }

    public function details($slug)
    {
        $data['title'] = 'Product Details';
        $product = Product::withCount('reviews')->with(['product_image', 'category', 'flash', 'brand:id,name'])->where('slug', $slug)->first();
        if (! $product) {
            abort(404);
        }
        $data['product'] = $product;
        if (isset($data['product']->flash)) {
            $exp = Carbon::parse($data['product']->flash->expires_at);
        } else {
            $exp = Carbon::parse('2020-12-12');
        }

        $data['expires_at'] = $exp->addDays(1)->toDateString();
        $data['subcategory'] = SubCategory::where('id', $data['product']->sub_category_id)->first();
        $data['title'] = $product->meta_title ?? $data['product']->name;

        $data['meta_keyword'] = $data['product']->meta_key;
        $data['meta_description'] = $data['product']->meta_description;
        $data['meta_price'] = $product->new_price != null ? $product->new_price : $product->price;

        $data['description'] = Str::limit(strip_tags($data['product']->details), 150);
        $data['keyword'] = Str::slug($data['product']->name, ', ');
        $data['related_product'] = Product::where('slug', '!=', $slug)
            ->where(['category_id' => $data['product']->category_id])
            ->latest()->limit(6)->get();

        $data['reviews'] = Review::where('product_id', $data['product']->id)
            ->latest()
            ->get();

        $data['rating'] = round($data['reviews']->avg('rating') ?? 0, 1);

        $product = $data['product'];
        $product->view_count = $product->view_count + 1;
        $product->save();
        $tags = $product->tags()->pluck('id')->toArray();
        $data['selectedTags'] = Tag::whereIn('id', $tags)->get();

        return view('front.product-details', $data);
    }

    public function category($slug = false)
    {
        $data['title'] = 'Products';
        $product = new Product;

        if ($slug != false) {
            $category = Category::where('slug', $slug)->first();
            if (! $category) {
                abort(404);
            }
            $product = $product->where('category_id', $category->id)->where('status', 'active');
            $data['title'] = $category->name;
            $data['key'] = $category->slug;
            $data['count'] = $product->count();
            $data['sub_categories'] = SubCategory::where('category_id', $category->id)->orderBy('name', 'ASC')->get();
        }

        $product = $product->orderBy('id', 'DESC')->paginate(24);
        $data['products'] = $product;

        if ($slug != false) {
            $data['brands'] = $product->unique('brand_id');
        } else {
            $data['categories'] = Category::orderBy('name', 'ASC')->get();
        }

        return view('front.product', $data);
    }

    public function tagProduct($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $data['title'] = $tag->name;
        $data['key'] = $tag->slug;
        $data['count'] = Product::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.id', $tag->id);
        })->count();
        $data['products'] = Product::whereHas('tags', function ($query) use ($tag) {
            $query->where('tags.id', $tag->id);
        })
            ->with('reviews')
            ->orderBy('id', 'DESC')->paginate(24);

        $data['brands'] = $data['products']->unique('brand_id');

        return view('front.product', $data);
    }

    public function sale()
    {
        $data['title'] = 'Products on Sale';
        $products = Product::with(['category', 'brand'])->where('new_price', '!=', null)
            ->where('status', 'active')
            ->latest()->paginate(16);
        $data['products'] = $products;
        // $data['categories'] = Category::orderBy('name','ASC')->get();

        return view('front.product', $data);
    }

    public function subcategory($slug)
    {
        $product = new Product;
        $sub_category = SubCategory::where('slug', $slug)->first();
        if (! $sub_category) {
            abort(404);
        }
        $product = $product->where('sub_category_id', $sub_category->id)->where('status', 'active');
        $data['title'] = $sub_category->name;
        $data['sub_key'] = $sub_category->slug;
        $data['count'] = $product->count();

        $product = $product->orderBy('id', 'DESC')->paginate(24);
        $data['products'] = $product;
        $data['brands'] = $product->unique('brand_id');
        // $data['categories'] = Category::orderBy('name','ASC')->get();

        return view('front.product', $data);
    }

    public function brand($slug = false)
    {
        $data['title'] = 'Brands';
        $product = new Product;
        if ($slug != false) {
            $brand = Brand::where('slug', $slug)->first();
            if (! $brand) {
                abort(404);
            }
            $product = $product->where('brand_id', $brand->id)->where('status', 'active');
            $data['title'] = $brand->name;
            $data['count'] = $product->count();
        }
        $product = $product->orderBy('id', 'DESC')->paginate(24);
        $data['products'] = $product;
        $data['brand_categories'] = $product->unique('category_id');

        return view('front.product', $data);
    }

    public function concern($slug)
    {
        $concern = Concern::where('slug', $slug)->first();
        if (! $concern) {
            abort(404);
        }
        $product = new Product;
        $product = $product->where('concern_id', $concern->id)->where('status', 'active');
        $data['title'] = $concern->name ?? 'Concerns';
        $product = $product->orderBy('id', 'DESC')->paginate(24);
        $data['products'] = $product;

        return view('front.product', $data);
    }

    public function featured()
    {
        $data['title'] = 'Featured Products';
        $products = Product::with(['category', 'brand'])->where('is_featured', 1)
            ->where('status', 'active')
            ->latest()->paginate(24);
        $data['products'] = $products;
        $data['categories'] = Category::orderBy('name', 'ASC')->get();

        return view('front.product', $data);
    }

    public function new_arrival()
    {
        $data['title'] = 'New Arrival Products';
        $products = Product::with(['category', 'brand'])->where('is_featured', 2)
            ->where('status', 'active')
            ->latest()->paginate(24);
        $data['products'] = $products;
        $data['categories'] = Category::orderBy('name', 'ASC')->get();

        return view('front.product', $data);
    }

    public function best_selling()
    {
        $data['title'] = 'Best Selling Products';
        $products = Product::with(['category', 'brand'])->where('is_featured', 3)
            ->where('status', 'active')
            ->latest()->paginate(24);
        $data['products'] = $products;
        $data['categories'] = Category::orderBy('name', 'ASC')->get();

        return view('front.product', $data);
    }

    public function flash()
    {
        $data['title'] = 'Flash Sale Products';
        $date = Carbon::today()->toDateString();

        /*$products = Product::with(['category','brand'])->where('flash_sale', 1)
            ->where('expires_at', '>=', $date)
            ->where('status', 'active')
            ->latest()->paginate(24);
        $data['products'] = $products;*/

        $data['products'] = Product::with(['category', 'brand', 'flash'])->whereHas('flash', function ($q) {
            $q->where('flash_stock', '>', 0);
        })->where('stock', '>', 0)->where('status', 'active')->inRandomOrder()->paginate(24);

        $data['categories'] = Category::orderBy('name', 'ASC')->get();

        return view('front.product', $data);
    }

    public function offer()
    {
        $data['title'] = 'Announcements';
        $data['offers'] = Offer::latest()->paginate(4);

        return view('front.offer', $data);
    }

    public function seller()
    {
        $data['title'] = 'Sell with us';

        return view('front.seller', $data);
    }

    public function find(Request $request)
    {
        $data['title'] = 'Search';
        $data['categories'] = Category::orderBy('name', 'ASC')->get();
        $product = new Product;

        // search product
        if ($request->has('product') && $request->product != null) {

            $req_input = $request->product;
            $req_input_array = explode(' ', $req_input);
            // $words = array('adult','18+','toy','doll');
            $badWords = [
                'ass', 'asshole', 'bastard', 'bitch', 'blowjob', 'boner', 'boob', 'bullshit',
                'cock', 'crap', 'cunt', 'dick', 'dildo', 'dyke', 'fag', 'faggot', 'fuck',
                'fucking', 'jackass', 'jerk', 'jizz', 'motherfucker', 'nigger', 'nigga',
                'penis', 'piss', 'porn', 'pussy', 'retard', 'scumbag', 'shit', 'slut',
                'titties', 'tit', 'vagina', 'wanker', 'whore', 'anal', 'anus', 'ballsack',
                'bangbros', 'bdsm', 'bestiality', 'bimbo', 'blow job', 'bondage', 'boobs',
                'booty', 'bootycall', 'bukkake', 'cameltoe', 'chode', 'clit', 'clitoris',
                'coochie', 'cum', 'cumshot', 'deepthroat', 'doggystyle', 'douche',
                'ejaculation', 'erotica', 'fap', 'fellatio', 'fisting', 'footjob', 'gangbang',
                'handjob', 'hentai', 'horny', 'milf', 'mofo', 'nude', 'nudity', 'orgasm',
                'orgy', 'pegging', 'phallic', 'rimjob', 'scissoring', 'semen', 'sex', 'shemale',
                'sodomy', 'sperm', 'squirting', 'strap-on', 'stripper', 'sucks', 'tranny',
                'twat', 'vibrator', 'wank', 'xxx',
            ];

            $result = count(array_intersect($req_input_array, $badWords));
            if (! $result) {
                $exist = Search::where('look', $req_input)->first();
                if ($exist) {
                    $exist->count = $exist->count + 1;
                    $exist->save();
                } else {
                    $search = new Search;
                    $search->look = $req_input;
                    $search->count = 1;
                    $search->save();
                }
            } else {
                session()->flash('error', 'Your input contains inappropriate words.');

                return redirect()->back();
            }

            $product = $product->where('name', 'like', '%'.$request->product.'%')->where('status', 'active');
            $data['count'] = $product->count();
            /* $data['title'] = $request->product; */
        }

        // search via category
        if ($request->has('category') && $request->category != null) {
            $category = Category::where('slug', $request->category)->first();
            $id = $category->id;
            $product = $product->where('category_id', $id);
            $data['count'] = $product->count();
            $data['key'] = $request->category;
        }

        $product = $product->orderBy('id', 'DESC')->paginate(24);
        $data['products'] = $product;

        return view('front.product', $data);
    }

    public function short($key, $by)
    {
        // $data['categories'] = Category::orderBy('name','ASC')->get();
        $product = new Product;

        if ($by == 'low-to-high') {
            $category = Category::where('slug', $key)->first();
            $id = $category->id;
            $product = $product->where('category_id', $id)->orderBy('price', 'ASC');
            $data['count'] = $product->count();
            $data['title'] = $category->name;
            $data['key'] = $category->slug;
        }

        if ($by == 'high-to-low') {
            $category = Category::where('slug', $key)->first();
            $id = $category->id;
            $product = $product->where('category_id', $id)->orderBy('price', 'DESC');
            $data['count'] = $product->count();
            $data['title'] = $category->name;
            $data['key'] = $category->slug;
        }

        $product = $product->paginate(24);
        $data['products'] = $product;
        $data['sub_categories'] = SubCategory::where('category_id', $id)->orderBy('name', 'ASC')->get();
        $data['brands'] = $product->unique('brand_id');

        return view('front.product', $data);
    }

    public function subshort($key, $by)
    {
        // $data['categories'] = Category::orderBy('name','ASC')->get();
        $product = new Product;

        if ($by == 'low-to-high') {
            $sub_category = SubCategory::where('slug', $key)->first();
            $id = $sub_category->id;
            $product = $product->where('sub_category_id', $id)->orderBy('price', 'ASC');
            $data['count'] = $product->count();
            $data['title'] = $sub_category->name;
            $data['sub_key'] = $sub_category->slug;
        }

        if ($by == 'high-to-low') {
            $sub_category = SubCategory::where('slug', $key)->first();
            $id = $sub_category->id;
            $product = $product->where('sub_category_id', $id)->orderBy('price', 'DESC');
            $data['count'] = $product->count();
            $data['title'] = $sub_category->name;
            $data['sub_key'] = $sub_category->slug;
        }

        $product = $product->paginate(24);
        $data['products'] = $product;
        $data['brands'] = $product->unique('brand_id');

        return view('front.product', $data);
    }

    public function searchAutoComplete(Request $request)
    {
        return Product::select('name', 'slug')
            ->where('name', 'like', "%{$request->term}%")
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->get();

        /*return Search::select('look')
            ->where('look', 'like', "%{$request->term}%")
            ->distinct()
            ->orderBy('look', 'ASC')
            ->pluck('look');*/
    }
}
