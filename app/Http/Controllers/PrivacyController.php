<?php

namespace App\Http\Controllers;

use App\Privacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PrivacyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['notVendor','notOperator']);
    }


    public function index()
    {
        Gate::authorize('app.privacy.index');
        $data['title'] = 'Privacy & Policy';
        $data['privacies'] = Privacy::withTrashed()->first();

        return view('back.privacy.index',$data);
    }
    //insert & update
    public function store(Request $request)
    {
        $request->validate([
            'faq'=>'',
            'privacy'=>'',
            'terms'=>'',
            'cookie'=>'',
        ]);

        $privacy = $request->except('_token','files');

        $data_privacy=Privacy::withTrashed()->first();

        if($data_privacy){
            Privacy::find($data_privacy->id)->update($privacy);
            session()->flash('success','Privacy & Policy Updated Successfully');
        }
        else{
            Privacy::create($privacy);
            session()->flash('success','Privacy & Policy Inserted Successfully');
        }


        return redirect()->back();
    }
}
