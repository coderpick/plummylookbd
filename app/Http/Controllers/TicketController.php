<?php

namespace App\Http\Controllers;

use App\Dispute;
use App\Order;
use App\Point;
use App\Review;
use App\Ticket;
use App\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('notVendor');
    }

    public function index()
    {
        Gate::authorize('app.ticket.index');
        $data['title'] = 'Support Tickets';
        $data['tickets'] = Ticket::latest()->get();
        return view('back.support.tickets',$data);
    }

    public function closed()
    {
        $data['title'] = 'Closed Support Tickets';
        $data['tickets'] = Ticket::onlyTrashed()->latest()->get();
        return view('back.support.tickets',$data);
    }

    public function get($id)
    {
        return TicketReply::with('user')->where('ticket_id', $id)->latest()->get();
    }

    public function show($id)
    {
        $id = base64_decode($id);
        $data['title'] = 'Support Ticket details';
        $data['ticket'] = Ticket::withTrashed()->where('id', $id)->first();
        $data['replies'] = TicketReply::where('ticket_id', $data['ticket']->id)->orderBy('id', 'ASC')->get();

        return view('back.support.ticket_details',$data);
    }


    public function tickets()
    {
        $data['title'] = 'My Support Tickets';
        $id = Auth::user()->id;
        $orders = Order::where('user_id', $id)->latest()->get();
        $data['order_count'] = $orders->where('user_id', $id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $id)->count();
        $data['balance'] = Point::where('user_id', $id)->first();

        $tickets = new Ticket();
        //$tickets = $tickets->with(['reply']);
        $tickets = $tickets->where('user_id', $id)->withTrashed()->orderBy('id','DESC')->paginate(5);
        $data['ticket_count'] = $tickets->where('user_id', $id)->count();
        $data['tickets'] = $tickets;

        return view('front.customer.support.tickets',$data);
    }


    public function store(Request $request)
    {
        if ($request->subject == null || $request->message == null){
            session()->flash('error','Required Field Missing');
        }
        $id = Auth::user()->id;
        $order = Order::where('user_id', $id)->first();

        if (!$order){
            session()->flash('error','At least You have to one transaction to submit tickets');
            return redirect()->back();
        }

        $request->validate([
            'subject'=>'required',
            'message'=>'required',
        ]);

        $data = $request->except('_token');

        $data['user_id'] = $id;
        $data['ticket_number'] =  '#'.$id.time();

        Ticket::create($data);
        session()->flash('success','Support Ticket Submitted');
        return redirect()->back();
    }

    public function details($id)
    {
        $id = base64_decode($id);
        $user_id = Auth::user()->id;

        $data['title'] = 'Support Ticket Details';
        $data['order_count'] = Order::where('user_id', $user_id)->count();
        $data['dispute_count'] = Dispute::withTrashed()->where('user_id', $user_id)->count();
        $data['ticket_count'] = Ticket::withTrashed()->where('user_id', $user_id)->count();
        $data['review_count'] = Review::withTrashed()->where('user_id', $user_id)->count();
        $data['balance'] = Point::where('user_id', $user_id)->first();
        $data['ticket'] = Ticket::withTrashed()->where('id', $id)->first();
        $data['replies'] = TicketReply::where('ticket_id', $data['ticket']->id)->orderBy('id', 'ASC')->get();

        return view('front.customer.support.ticket_details',$data);
    }

    public function response(Request $request)
    {
        /*$request->validate([
            'ticket_id'=>'required',
            'reply'=>'required',
        ]);

        $data = $request->except('_token');

        $data['user_id'] = Auth::user()->id;

        TicketReply::create($data);
        return redirect()->back();*/
        TicketReply::create($request->all());
        return ['success'=> true, 'message'=> 'Added successfully' ];
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply'=>'required',
        ]);

        $data = $request->except('_token');

        $data['ticket_id'] = $id;
        $data['user_id'] = Auth::user()->id;

        TicketReply::create($data);
        //session()->flash('success','Replied Successfully');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $ticket= Ticket::where('id', $id)->first();
        $ticket->delete();
        $ticket->update(['updated_by'=>Auth::user()->id]);

        session()->flash('success','Ticket Closed Successfully');
        return redirect()->back();
    }


    public function restore($id)
    {
        $ticket = Ticket::onlyTrashed()->findOrFail($id);
        $ticket->restore();
        $ticket->update(['updated_by'=>Auth::user()->id]);

        session()->flash('success','Ticket Reopened Successfully');
        return redirect()->back();
    }
}
