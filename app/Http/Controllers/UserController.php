<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\Blocked;
use App\Order;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {
        Gate::authorize('users.index');
        $data['title'] ="Users";
        $data['users'] = User::withTrashed()->with( 'roles' )->where('type','admin')->where('email','!=','admin@mail.com')->get();
        return view('back.admin.index',$data);


    }

    public function create()
    {
        Gate::authorize('users.create');
        $data['roles'] =  Role::get();
        $data['title']= 'Create User';
        return  view('back.admin.create',$data);
    }


    public function store(UserStoreRequest $request)
    {

        Gate::authorize('users.create');

        $user = new User();
        $user->name           = $request->name;
        $user->slug           = str_slug($request->name);
        $user->type           = 'admin';
        $user->email          = $request->email;
        $user->nid            = $request->nid;
        $user->phone          = $request->phone;
        $user->password       = Hash::make($request->password);
        $user->email_verified_at= Carbon::now();
        $user->status         = $request->filled('status');
        if ($request->hasFile('image')){
            $slug = str_slug($request->name);
            $image = $request->file('image');
            $file_name = $slug. '_' . time();
            $upload_path = 'uploads/avatar/';
            $filePath = $upload_path . $file_name. '.'. $image->getClientOriginalExtension();
            $image_url = $upload_path . $filePath;
            $image->move($upload_path, $image_url);
            $user->image = $filePath;
        }
        $user->save();
        $user->roles()->sync($request->input('roles'),[]);
        session()->flash('success', 'User Create Successfully');
        return redirect()->route('user.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data['title']="Profile";
        return view('back.admin.view',$data);
    }

    public function details($slug)
    {
        $data['title']="Customer Details";
        $data['user']=User::where('slug',$slug)->first();
        $data['orders']=Order::where('user_id',$data['user']->id)->count();
        return view('back.admin.customer_details',$data);
    }

    public function edit($id)
    {
        Gate::authorize('users.edit');
        $data['roles'] =  Role::get();
        $data['title']= 'Edit User';
        $data['user']= User::findOrFail($id);
        return  view('back.admin.edit',$data);
    }


    public function update(UserUpdateRequest $request, $id)
    {
        Gate::authorize('users.edit');
        $user                 = User::findOrFail($id);
        $user->name           = $request->name;
        $user->slug           = str_slug($request->name);
        $user->email          = $request->email;
        $user->nid            = $request->nid;
        $user->phone          = $request->phone;
        $user->password       = isset($request->password)?Hash::make($request->password):$user->password;
        $user->status         = $request->filled('status');
        if ($request->hasFile('image')){
            $slug = str_slug($request->name);
            $image = $request->file('image');
            $file_name = $slug. '_' . time();
            $upload_path = 'uploads/avatar/';
            $filePath = $upload_path . $file_name. '.'. $image->getClientOriginalExtension();
            $image_url = $upload_path . $filePath;
            if ($user->image != null && File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $image->move($upload_path, $image_url);
            $user->image = $filePath;
        }
        $user->save();
        $user->roles()->sync($request->input('roles'));
        session()->flash('success', 'User Update Successfully');
        return redirect()->route('user.index');


    }

    public function trash($id)
    {
        Gate::authorize('users.trash');
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success','User Temporary Delete');
        return redirect()->route('user.index');
    }

    public function restore($id)
    {
        Gate::authorize('users.restore');
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success','User Restored Successfully');
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        Gate::authorize('users.destroy');
        $user =  User::withTrashed()->findOrFail($id);
        if ($user->image != null && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }
        $user->forceDelete();
        session()->flash('success','User Deleted Successfully');
        return redirect()->route('user.index');
    }


    public function customer()
    {
        if (Auth::user()->type == 'operator'){
            session()->flash('error', 'Unauthorized Request');
            return redirect()->back();
        }

        $data['title'] = 'Customer List';
        $data['users'] = User::where('type', 'user')->latest()->withTrashed()->get();

        return view('back.admin.customer',$data);
    }


    public function customer_destroy(User $user)
    {
        Mail::to($user->email)->send(new Blocked());
        $user->delete();
        session()->flash('success','Customer Blocked Successfully');
        return redirect()->route('customer');
    }

    public function customer_restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        session()->flash('success','Customer Unblock Successfully');
        return redirect()->route('customer');
    }
}
