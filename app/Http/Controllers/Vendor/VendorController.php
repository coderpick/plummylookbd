<?php

namespace App\Http\Controllers\Vendor;
use App\Category;
use App\Http\Controllers\Controller;

use App\Mail\Blocked;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Shop;
use App\SubCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','notOperator'])->except(['vendors_shop','shop_product']);
    }


    public function index()
    {
        $data['title'] = 'Vendors';
        $data['users'] = User::where('type','vendor')->get();
        return view('back.vendor.index',$data);
    }

    public function pending()
    {
        $data['title'] = 'Pending Vendors';
        $data['users'] = User::onlyTrashed()->where('type','vendor')->where('status',0)->get();
        return view('back.vendor.index',$data);
    }

    public function blocked()
    {
        $data['title'] = 'Blocked Vendors';
        $data['users'] = User::onlyTrashed()->where('type','vendor')->where('status',1)->get();
        return view('back.vendor.index',$data);
    }

    public function create()
    {
        $data['title']= 'Vendor';
        return view('back.vendor.create',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'shop' => 'required|unique:shops,name',
            'name' => 'required',
            'phone' => 'required|numeric|min:11',
            'nid' => 'nullable|numeric|digits_between:10,17',
            'sequence' => 'required|numeric|min:1',
            'image' => 'image',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = $request->except('_token', 'password','password_confirmation','shop','sequence');
        $data['password'] = bcrypt($request->password);
        $slug = Str::slug($request->name, '-').'-'.rand(000,999);
        $data['slug'] = $slug;
        $data['type'] = 'vendor';
        $data['status'] = 1;
        $data['nid'] = $request->nid;
        $data['created_at'] = Carbon::now();
        //$data['deleted_at'] = Carbon::now();
        $data['email_verified_at'] = Carbon::now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = $slug.rand(000,999).$file->getClientOriginalName();
            $file->move('uploads/admin/',$file_name);
            $data['image'] = 'uploads/admin/' . $file_name;
        }

        $user_id = User::insertGetId($data);

        $shop_slug = Str::slug($request->shop, '-');
        $shop['name'] = $request->shop;
        $shop['sequence'] = $request->sequence;
        $shop['slug'] = $shop_slug;
        $shop['user_id'] = $user_id;
        Shop::create($shop);

        session()->flash('success', 'Vendor Created Successfully');
        return redirect()->route('vendor.index');
    }


    public function details($slug)
    {
        $data['title']="Vendor Details";
        $data['user']=User::with('shop')->where('slug',$slug)->first();

        $shop = $data['user']->shop;
        $data['product']=product::where('shop_id', $shop->id)->count();

        $data['order'] = Order::latest()->whereHas('order_detail', function ($query) use($shop){
            $query->where('shop_id', $shop->id);
        })->count();

        return view('back.vendor.details',$data);
    }


    public function accept(Request $request,$id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->update(['status'=>1]);
        $shop = Shop::where('user_id', $id )->first();
        //$shop->update(['commission'=> $request->commission]);
        $user->restore();
        session()->flash('success','Vendor Accepted');
        return redirect()->back();
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        //$user->update(['status'=>'active']);

        $products = Product::onlyTrashed()->where('shop_id', $user->shop->id)->get();
        foreach ($products as $product){
            $product->restore();
        }

        $user->restore();
        session()->flash('success','Vendor Unblocked Successfully');
        return redirect()->back();
    }


    public function destroy($slug)
    {
        $user = User::where('slug',$slug)->first();
        Mail::to($user->email)->send(new Blocked());
        $products = Product::where('shop_id', $user->shop->id)->get();
        foreach ($products as $product){
            $product->delete();
        }

        $user->delete();
        session()->flash('success','Vendor Blocked Successfully');
        return redirect()->back();
    }


    public function delete($id)
    {
        $shop = Shop::where('user_id', $id)->first();
        $shop->forceDelete();
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        session()->flash('success','Vendor deleted Successfully');
        return redirect()->route('vendor.blocked');
    }


    public function get_product($slug)
    {
        $shop = Shop::where('slug', $slug)->first();
        $data['vendor'] = 'Vendor';
        $data['title'] = ucfirst($shop->name).' Products';
        $data['products'] = Product::withTrashed()->where('shop_id', $shop->id)->get();
        return view('back.product.index',$data);
    }

    public function get_order($slug)
    {
        $shop = Shop::where('slug', $slug)->first();
        $data['title'] = ucfirst($shop->name).' Orders';

        $data['orders'] = Order::latest()->whereHas('order_detail', function ($query) use($shop){
           $query->where('shop_id', $shop->id);
       })->get();

        return view('back.order.index',$data);
    }


    public function shop_product($slug)
    {
        $product = new Product();
        $shop = Shop::where('slug', $slug)->first();
        $product = $product->where('shop_id', $shop->id)->where('status', 'active');

        $data['title'] = $shop->name ;
        //$data['sub_key'] = $shop->slug;
        $data['count'] = $product->count();


        $product = $product->orderBy('id','DESC')->paginate(16);
        $data['products'] =$product;
        $data['categories'] = Category::orderBy('name','ASC')->get();


        return view('front.product', $data);
    }



    public function shop()
    {
        $data['shop']= Auth::user()->shop;
        $data['title']= ucfirst($data['shop']->name);
        return view('back.admin.shop',$data);
    }

    public function edit($slug)
    {
        $data['title']= 'Vendor';
        $data['user']=User::with('shop')->where('slug',$slug)->first();

        return view('back.vendor.edit',$data);
    }

    public function vendor_update(Request $request, $id)
    {
        $request->validate([
            'shop' => 'required',
            'name' => 'required',
            'phone' => 'required|numeric|min:11',
            'nid' => 'nullable|numeric|digits_between:10,17',
            'sequence' => 'required|numeric|min:1',
            'image' => 'image',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $data = $request->except('_token', 'password','password_confirmation','shop');
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $slug = Str::slug($request->name, '-').'-'.rand(000,999);
        $data['slug'] = $slug;
        $data['nid'] = $request->nid;
        $user = User::findOrFail($id);
        $user->update($data);

        $shop_slug = Str::slug($request->shop, '-');
        $shop['name'] = $request->shop;
        $shop['sequence'] = $request->sequence;
        $shop['slug'] = $shop_slug;
        $vendor = Shop::where('user_id', $user->id)->first();
        $vendor->update($shop);

        session()->flash('success', 'Vendor Updated Successfully');
        return redirect()->route('vendor.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image',
            'cheque' => 'image',
            'acc_no' => 'required|numeric',
            'routing_no' => 'required',
        ]);

        $shop = Shop::findOrFail($id);
        $data = $request->except('_token', 'image','cheque');
        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;
        $data['description'] = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = $slug.rand(000,999).$file->getClientOriginalName();
            $file->move('uploads/shop/',$file_name);
            if ($shop->image != null){
                unlink($shop->image);
            }
            $data['image'] = 'uploads/shop/' . $file_name;
        }
        if ($request->hasFile('cheque') && $shop->cheque == null) {
            $file = $request->file('cheque');
            $file_name = $slug.rand(000,999).$file->getClientOriginalName();
            $file->move('uploads/shop/cheque/',$file_name);
            if ($shop->cheque != null){
                unlink($shop->cheque);
            }
            $data['cheque'] = 'uploads/shop/cheque/' . $file_name;
        }


        $shop->update($data);
        session()->flash('success', 'Updated successfully');

        return redirect()->back();
    }



    public function vendors_shop()
    {
        $data['title']= 'Stores';
        $data['shops']= Shop::latest()->paginate(24);

        return view('front.shops',$data);
    }
}
