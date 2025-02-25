<?php

namespace App\Http\Controllers;

use App\Dispute;
use App\DisputeReply;
use App\Order;
use App\Point;
use App\Review;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DisputeController extends Controller
{

    public function __construct()
    {
        $this->middleware('notVendor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.dispute.index');
        $data['title'] = 'Returns';
        $data['disputes'] = Dispute::latest()->get();
        return view('back.support.disputes',$data);
    }

    public function closed()
    {
        $data['title'] = 'Closed Returns';
        $data['disputes'] = Dispute::onlyTrashed()->latest()->get();
        return view('back.support.disputes',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $id = base64_decode($id);
        $data['title'] = 'Return details';
        $data['dispute'] = Dispute::withTrashed()->where('id', $id)->first();
        //$data['replies'] = DisputeReply::where('dispute_id', $data['dispute']->id)->orderBy('id', 'ASC')->get();

        return view('back.support.dispute_details',$data);
    }

    public function get($id)
    {
        /*$id = base64_decode($id);*/
        return DisputeReply::with('user')->where('dispute_id', $id)->latest()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dispute  $dispute
     * @return \Illuminate\Http\Response
     */

    public function disputes()
    {
        $data['title'] = 'My Returns';
        $id = Auth::user()->id;
        $orders = Order::where('user_id', $id)->latest()->get();
        $data['order_count'] = $orders->where('user_id', $id)->count();

        $disputes = new Dispute();
        //$disputes = $disputes->with(['reply']);
        $disputes = $disputes->where('user_id', $id)->withTrashed()->orderBy('id','DESC')->paginate(5);
        $data['dispute_count'] = $disputes->where('user_id', $id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $id)->count();
        $data['balance'] = Point::where('user_id', $id)->first();
        $data['disputes'] = $disputes;
        $data['orders']=[];


        /*get only orders with no dispute for select option to create new dispute*/
        $completed_orders = $orders->where('status', 'Delivered');

        if(count($disputes)>0){
            foreach($completed_orders as $order){
                $val=false;
                foreach($disputes as $dispute){
                    if($dispute->order_id==$order->id){
                        $val=false;
                        break;
                    }
                    else{
                        $val=true;
                    }
                }
                if($val){
                    $data['orders'][]=$order;
                }
            }
        }
        else{
            $data['orders']=$completed_orders;
        }


        return view('front.customer.support.disputes',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->order_id == null || $request->subject == null || $request->message == null){
            session()->flash('error','Required Field Missing');
        }
        $request->validate([
            'order_id'=>'required',
            'subject'=>'required',
            'message'=>'required',
            'image'=>'required|image',
        ]);
        $data = $request->except('_token','image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = 'rtn'.rand(000,999).$file->getClientOriginalName();
            $file->move('uploads/returns/',$file_name);

            $data['image'] = 'uploads/returns/' . $file_name;
        }



        $data['user_id'] = Auth::user()->id;

        Dispute::create($data);
        session()->flash('success','Return Submitted');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dispute  $dispute
     * @return \Illuminate\Http\Response
     */

    public function details($id)
    {
        $id = base64_decode($id);
        $user_id = Auth::user()->id;

        $data['title'] = 'Return Details';
        $data['order_count'] = Order::where('user_id', $user_id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $user_id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $user_id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $user_id)->count();
        $data['balance'] = Point::where('user_id', $user_id)->first();
        $data['dispute'] = Dispute::withTrashed()->where('id', $id)->first();
        $data['replies'] = DisputeReply::where('dispute_id', $data['dispute']->id)->orderBy('id', 'ASC')->get();

        return view('front.customer.support.dispute_details',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dispute  $dispute
     * @return \Illuminate\Http\Response
     */
    public function response(Request $request)
    {
        /*$request->validate([
            'dispute_id'=>'required',
            'reply'=>'required',
        ]);

        $data = $request->except('_token');

        $data['user_id'] = Auth::user()->id;

        DisputeReply::create($data);
        return redirect()->back();*/


        DisputeReply::create($request->all());
        return ['success'=> true, 'message'=> 'Added successfully' ];
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply'=>'required',
        ]);

        $data = $request->except('_token');

        $data['dispute_id'] = $id;
        $data['user_id'] = Auth::user()->id;

        DisputeReply::create($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dispute  $dispute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dispute= Dispute::where('id', $id)->first();
        $dispute->delete();
        $dispute->update(['updated_by'=>Auth::user()->id]);

        session()->flash('success','Return Closed Successfully');
        return redirect()->back();
    }


    public function restore($id)
    {
        $dispute = Dispute::onlyTrashed()->findOrFail($id);
        $dispute->restore();
        $dispute->update(['updated_by'=>Auth::user()->id]);

        session()->flash('success','Return Reopened Successfully');
        return redirect()->back();
    }
}
