<?php

namespace App\Http\Controllers;

use App\Concern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ConcernController extends Controller
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
        Gate::authorize('app.category.index');
        $data['title'] = 'Concern';
        $data['concerns'] = Concern::withTrashed()->get();
        return view('back.concern.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Concern';
        return view('back.concern.create',$data);
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
            'name'=>'required|unique:concerns',
            'icon'=>'required|image',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/concern/',$file_name);
            $data['icon'] = 'uploads/concern/' . $file_name;
        }

        Concern::create($data);
        session()->flash('success','Concern Created Successfully');
        return redirect()->route('concern.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Concern  $concern
     * @return \Illuminate\Http\Response
     */
    public function show(Concern $concern)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Concern  $concern
     * @return \Illuminate\Http\Response
     */
    public function edit(Concern $concern)
    {
        $data['title'] = 'Concern';
        $data['concern'] = $concern;
        return view('back.concern.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Concern  $concern
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Concern $concern)
    {
        $request->validate([
            'name'=>'required',
            'icon'=>'nullable|image',
        ]);
        $data = $request->except('_token');

        $slug = Str::slug($request->name, '-');
        $data['slug'] = $slug;

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $file_name = $slug.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/concern/',$file_name);
            if ($concern->icon != null){
                unlink($concern->icon);
            }
            $data['icon'] = 'uploads/concern/' . $file_name;
        }

        $concern->update($data);
        session()->flash('success','Concern Updated Successfully');
        return redirect()->route('concern.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Concern  $concern
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concern $concern)
    {
        $concern->delete();
        session()->flash('success','Concern Deleted Successfully');
        return redirect()->route('concern.index');
    }

    public function restore($id)
    {
        $concern = Concern::onlyTrashed()->findOrFail($id);
        $concern->restore();
        session()->flash('success','Concern Restored Successfully');
        return redirect()->route('concern.index');
    }

    public function delete($id)
    {
        $concern = Concern::onlyTrashed()->findOrFail($id);
        if ($concern->icon != null){
            unlink($concern->icon);
        }
        $concern->forceDelete();
        session()->flash('success','Concern Permanently Removed');
        return redirect()->route('concern.index');
    }
}
