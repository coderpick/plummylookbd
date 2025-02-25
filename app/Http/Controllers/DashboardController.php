<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Dispute;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Review;
use App\Subscribe;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == 'vendor'){
            $order = Order::latest()->whereHas('order_detail', function ($query){
                $query->where('shop_id', Auth::user()->shop->id);
            })->get();


            $data['pending'] = $order->where('status','Pending')->count();
            $data['confirmed'] = $order->where('status','Confirmed')->count();
            $data['processing'] = $order->where('status','Processing')->count();
            $data['shipped'] = $order->where('status','Shipped')->count();
            $data['delivered'] = $order->where('status','Delivered')->count();
            $data['canceled'] = $order->where('status','Canceled')->count();

            $data['order30'] = Order::whereHas('order_detail', function ($query){
                $query->where('shop_id', Auth::user()->shop->id);
            })->whereDate('created_at','>', Carbon::now()->subDays(30))->count();
            $data['total_order'] = $order->count();

            $data['customer'] = Product::where('shop_id',Auth::user()->shop->id)->whereDate('created_at','>', Carbon::now()->subDays(30))->count();
            $data['total_customer'] = Product::where('shop_id',Auth::user()->shop->id)->count();





            /*MONTHLY SALES CALCULATION*/
            // 12 months define
            for ($month = 1; $month <= 12; $month++) {
                // current year and the current month (e.g. 2019-01-01 00:00:00)
                $date = Carbon::create(date('Y'), $month);

                // copy start date and get end of the month (e.g. 2019-01-31 23:59:59)
                $date_end = $date->copy()->endOfMonth();

                // orders between the start of the month and the end of the month
                $orders = Order::whereHas('order_detail', function ($query){
                    $query->where('shop_id', Auth::user()->shop->id);
                })->where('date', '>=', $date)
                    ->where('date', '<=', $date_end)
                    ->Where('status','!=','Canceled')
                    ->count();


                /*$amounts = Order::whereHas('order_detail', function ($query){
                            $query->where('shop_id', Auth::user()->shop->id);
                        })->where('date', '>=', $date)
                    ->where('date', '<=', $date_end)
                    ->Where('status','!=','Canceled')
                    ->sum(\DB::raw('amount - shipping'));*/
                $amounts = OrderDetail::where('shop_id',Auth::user()->shop->id )->where('created_at', '>=', $date)
                    ->where('created_at', '<=', $date_end)
                    ->Where('status','!=','Canceled')
                    ->sum(\DB::raw('total'));


                // count of orders for the month in array
                $sale[$month] = $orders;
                $data['sale'] = $sale;

                // amount of orders for the month in array
                $amount[$month] = $amounts;
                $data['amount'] = $amount;
            }

            //Top selling product
            $data['top_selling'] = Product::withCount('order_detail')
                ->where('shop_id', Auth::user()->shop->id)
                ->orderBy('order_detail_count', 'DESC')
                ->take(10)
                ->get();

        }

        else{
            $order=Order::get();
            //$data['admin'] = User::where('type','!=', 'user')->where('type','!=', 'superadmin')->count();
            //$data['user'] = User::where('type','user')->count();
            $data['brand'] = Brand::count();
            $data['category'] = Category::count();
            $data['product'] = Product::count();
            $data['pending'] = $order->where('status','Pending')->count();
            $data['confirmed'] = $order->where('status','Confirmed')->count();
            $data['processing'] = $order->where('status','Processing')->count();
            $data['shipped'] = $order->where('status','Shipped')->count();
            $data['delivered'] = $order->where('status','Delivered')->count();
            $data['canceled'] = $order->where('status','Canceled')->count();
            $data['order30'] = Order::whereDate('created_at','>', Carbon::now()->subDays(30))->count();
            $data['total_order'] = $order->count();
            $data['customer'] = User::where('type','user')->whereDate('created_at','>', Carbon::now()->subDays(30))->count();
            $data['total_customer'] = User::where('type','user')->count();
            $data['subscriber'] = Subscribe::count();


            $data['disputes'] = Dispute::where('deleted_at', null)->count();
            $data['disputes_closed'] = Dispute::onlyTrashed()->count();

            $data['tickets'] = Ticket::where('deleted_at', null)->count();
            $data['tickets_closed'] = Ticket::onlyTrashed()->count();

            $data['reviews'] = Review::where('deleted_at', null)->count();
            $data['reviews_pending'] = Review::onlyTrashed()->count();

            $data['vendors'] = User::where('type','vendor')->where('deleted_at', null)->count();
            $data['vendors_pending'] = User::onlyTrashed()->where('type','vendor')->count();


            /*MONTHLY SALES CALCULATION*/
            // 12 months define
            for ($month = 1; $month <= 12; $month++) {
                // current year and the current month (e.g. 2019-01-01 00:00:00)
                $date = Carbon::create(date('Y'), $month);

                // copy start date and get end of the month (e.g. 2019-01-31 23:59:59)
                $date_end = $date->copy()->endOfMonth();

                // orders between the start of the month and the end of the month
                $orders = Order::where('date', '>=', $date)
                    ->where('date', '<=', $date_end)
                    ->Where('status','!=','Canceled')
                    ->count();


                $amounts = Order::where('date', '>=', $date)
                    ->where('date', '<=', $date_end)
                    ->Where('status','!=','Canceled')
                    ->sum(\DB::raw('amount - shipping'));


                // count of orders for the month in array
                $sale[$month] = $orders;
                $data['sale'] = $sale;

                // amount of orders for the month in array
                $amount[$month] = $amounts;
                $data['amount'] = $amount;
            }


            //Top selling product
            $data['top_selling'] = Product::withCount('order_detail')
                ->orderBy('order_detail_count', 'DESC')
                ->take(10)
                ->get();

            $data['daily_orders'] = Order::withCount('order_detail')->whereDate('created_at', Carbon::today())->paginate(10);

        }


        /*END OF MONTHLY SALES CALCULATION*/
//return $data;
        return view('back.dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
