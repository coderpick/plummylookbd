<?php

namespace App\Http\Controllers;

use App\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MetaController extends Controller
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
        Gate::authorize('app.meta.index');
        $data['title'] = 'Meta';
        $data['meta'] = Meta::withTrashed()->first();

        return view('back.meta.index',$data);

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
            'title'=>'required',
            'keyword'=>'required',
            'description'=>'required',
        ]);
        $meta = $request->except('_token');


        $table_data=Meta::withTrashed()->first();

        if($table_data){
            Meta::find($table_data->id)->update($meta);
            session()->flash('success','Meta Updated Successfully');
        }
        else{
            Meta::create($meta);
            session()->flash('success','Meta Inserted Successfully');
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function show(Meta $meta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function edit(Meta $meta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meta $meta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meta $meta)
    {
        //
    }
}
