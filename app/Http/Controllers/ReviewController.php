<?php

namespace App\Http\Controllers;

use App\Dispute;
use App\Order;
use App\OrderDetail;
use App\Point;
use App\Product;
use App\Review;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.review.index');
        $data['title'] = 'Reviews';
        if (Auth::user()->type == 'vendor'){
            $data['reviews'] = Review::where('user_id','!=',null)->where('shop_id',Auth::user()->shop->id)->get();
        }
        else{
            $data['reviews'] = Review::where('user_id','!=',null)->get();
        }

        return view('back.review.index',$data);
    }

    public function pending()
    {
        $data['title'] = 'Pending Reviews';
        if (Auth::user()->type == 'vendor'){
            $data['reviews'] = Review::onlyTrashed()->where('user_id','!=',null)->where('shop_id',Auth::user()->shop->id)->get();
        }
        else{
            $data['reviews'] = Review::onlyTrashed()->where('user_id','!=',null)->get();
        }

        return view('back.review.index',$data);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $data['title'] = $product->name;

        if (Auth::user()->type == 'vendor'){
            $data['reviews'] = Review::where('shop_id',Auth::user()->shop->id)->where('product_id', $product->id)->get();
        }
        else{
            $data['reviews'] = Review::where('product_id', $product->id)->get();
        }

        return view('back.review.index',$data);
    }

    public function user($slug)
    {
        $user = User::where('slug', $slug)->first();
        $data['title'] = $user->name;

        if (Auth::user()->type == 'vendor'){
            $data['reviews'] = Review::where('shop_id',Auth::user()->shop->id)->where('user_id', $user->id)->get();
        }
        else{
            $data['reviews'] = Review::where('user_id', $user->id)->get();
        }

        return view('back.review.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews()
    {
        if (Auth::user()->type != 'user'){
            session()->flash('error','Unauthorized Request');
            return redirect()->back();
        }

        $data['title'] = 'My Reviews';
        $id = Auth::user()->id;
        $data['order_count'] = Order::where('user_id', $id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $id)->count();
        $data['balance'] = Point::where('user_id', $id)->first();
        $data['reviews'] = Review::withTrashed()->where('user_id', $id)->paginate(5);
        return view('front.customer.reviews',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user= Auth::user();

        if ($user->type != 'user'){
            session()->flash('error','Unauthorized Request');
            return redirect()->back();
        }

        if (! $request->star){
            session()->flash('error','Rating is required');
            return redirect()->back();
        }
        if ($request->review == null){
            session()->flash('error','Review is required');
            return redirect()->back();
        }
        $request->validate([
            'star'=>'required',
            'review'=>'required|max:250'
        ]);
        $data = $request->except('_token');


        $exist = Review::withTrashed()->where('user_id',$user->id)->where('product_id',$request->product)->first();
        if ($exist){
            session()->flash('error','Review Already Submitted');
            return redirect()->back();
        }


        //check user ordered this product or not
        $order_detail=OrderDetail::where('status','Delivered')->whereIn('order_id',function($query) use ($user){
            return $query->select('id')->from('orders')->where('user_id',$user->id);
        })->pluck('product_id');
        if(in_array($request->product,$order_detail->toarray())){
            $val = 1;
        }
        else{
            $val = 0;
        }

       if($val == 1){
           $review = new Review;
           $review->user_id = $user->id;
           $review->name = $user->name;
           $review->product_id = $request->product;
           $review->shop_id = $request->shop;
           $review->rating = $request->star;
           $review->review = $request->review;
           $review->deleted_at = Carbon::now();
           $review->save();

           session()->flash('success','Review Submitted Successfully');
           return redirect()->back();
       }
       else{
           session()->flash('error','Only you can submit a review, when product is delivered');
           return redirect()->back();
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $review = Review::onlyTrashed()->findOrFail($id);
        $review->restore();
        session()->flash('success','Review Approved Successfully');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::withTrashed()->findOrFail($id);
        $review->forceDelete();
        session()->flash('success','Review Deleted Successfully');
        return redirect()->back();
    }
}
