<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Link;
use App\Mail\ContactUs;
use App\Mail\Newsletter;
use App\Product;
use App\Search;
use App\Subscribe;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 'operator'){
            session()->flash('error', 'Unauthorized Request');
            return redirect()->back();
        }

        $data['title'] = 'Subscribers';
        $data['subscribers'] = Subscribe::get();
        return view('back.subscribers',$data);
    }

    public function create()
    {
        $data['title'] = 'Unsubscribe';
        return view('front.unsubscribe',$data);
    }

    public function store(Request $request)
    {
        session()->flash('success','Thank you for your subscription.');
        $request->validate([
            'email'=>'unique:subscribes|email',
        ]);
        $data= $request->except('_token');
        Subscribe::create($data);

        return redirect()->back();
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email'=>'email',
        ]);
        $email= $request->email;
        $email= Subscribe::where('email', $email)->first();

        if ($email != null){
            $email->delete();
            session()->flash('success','Subscription changes have been successfully made');
            $data['title'] = 'Unsubscribe';
            $data['link'] = Link::latest()->first();
            return view('front.msg',$data);
        }
        else{
            session()->flash('error','Oops! email is not found');
            return redirect()->back();
        }
    }

    public function contact_us()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'required',
        ]);
        $contact = Contact::orderBy('id','desc')->first();
        $email =$contact->email;
        Mail::to($email)->send(new ContactUs($data));
        session()->flash('success','Thank you for your message !');
        return redirect()->back();
    }


    public function newsletter(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'details'=>'required',
        ]);
        $data= $request->except('_token');

        $data['title']= $request->title;
        $data['details']= $request->details;

        $subscribers = Subscribe::get();
        if ($request->type == 'user'){
            $subscribers = User::where('type', 'user')->get();
        }
        if ($request->type == 'vendor'){
            $subscribers = User::where('type', 'vendor')->get();
        }

        foreach ($subscribers as $subscriber){
            Mail::to($subscriber->email)->send(new Newsletter($data));
            /*dispatch(new NewsletterJob($data))->delay(Carbon::now()->addSeconds(3));*/
        }

        /*Artisan::call('queue:work --stop-when-empty')->hourly();*/
        session()->flash('success','Newsletter Successfully Sent');
        return redirect()->back();
    }


    public function queue()
    {
        Artisan::call('queue:work')->everyMinute();
        /*Artisan::call('queue:work --stop-when-empty')->everyMinute();*/
        return redirect()->back();
    }


    public function update(Request $request, Subscribe $subscribe)
    {
        //
    }


    public function destroy($id)
    {
        $subscriber = Subscribe::findOrFail($id);
        $subscriber->delete();
        session()->flash('success','Subscribe Removed Successfully');
        return redirect()->back();
    }

    public function searches()
    {
        $data['title'] = 'Searches';
        $data['searches'] = Search::orderBy('count','DESC')->paginate(10);
        return view('back.searches',$data);
    }

    public function customer_click()
    {
        $data['products'] = Product::withTrashed()->where('view_count','!=', null)->orderBy('view_count','DESC')->limit(200)->paginate(10);
        $data['title'] = 'Customer Click';
        return view('back.customer_click',$data);
    }



}
