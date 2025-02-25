<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LinkController extends Controller
{

    public function __construct()
    {
        $this->middleware(['notVendor','notOperator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.link.index');

        $data['title'] = 'Logo And Links';
        $data['logo_links'] = Link::withTrashed()->first();

        return view('back.logo_links.index',$data);

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
        $request->validate([
            'logo'=>'image|max:10000',
            'footer_logo'=>'image|max:10000',
            'facebook'=>'max:1000',
            'twitter'=>'max:1000',
            'instagram'=>'max:1000',
            'skype'=>'max:1000',
        ]);
        $links = $request->except('_token','logo','footer_logo');

        $data_logo_links=Link::withTrashed()->first();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file_name = time().'tl'.rand(0000,9999).'.'.$file->getClientoriginalExtension();
            if($data_logo_links){
                unlink($data_logo_links->logo);
            }
            $file->move('uploads/logo/',$file_name);
            $links['logo'] = 'uploads/logo/' . $file_name;
        }

        if ($request->hasFile('footer_logo')) {
            $file = $request->file('footer_logo');
            $file_name = time().'fl'.rand(0000,9999).'.'.$file->getClientoriginalExtension();
            if($data_logo_links && $data_logo_links->footer_logo != null){
                unlink($data_logo_links->footer_logo);
            }
            $file->move('uploads/logo/',$file_name);
            $links['footer_logo'] = 'uploads/logo/' . $file_name;
        }

        if($data_logo_links){
            Link::find($data_logo_links->id)->update($links);
            session()->flash('success','Logo & Links Updated Successfully');
        }
        else{
            Link::create($links);
            session()->flash('success','Logo & Links Inserted Successfully');
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        //
    }
}
