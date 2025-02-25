<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SliderController extends Controller
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
        Gate::authorize('app.slider.index');
            $data['title'] = 'Slider';
            $data['sliders'] = Slider::withTrashed()->get();
            return view('back.slider.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type !== 'operator'){
            $data['title'] = 'Slider';
            return view('back.slider.create',$data);
        }
        else{
            session()->flash('error','Unauthorized Request');
        }
        return redirect()->back();
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
            'image'=>'required|image',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time().'fl'.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/slider/',$file_name);
            $data['image'] = 'uploads/slider/' . $file_name;
        }

        Slider::create($data);
        session()->flash('success','Slider Added Successfully');
        return redirect()->route('slider.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        if (Auth::user()->type !== 'operator'){
            $data['title'] = 'Slider Update';
            $data['slider'] = $slider;
            return view('back.slider.edit',$data);
        }
        else{
            session()->flash('error','Unauthorized Request');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'image',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time().'fl'.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/slider/',$file_name);
            if ($slider->image != null){
                unlink($slider->image);
            }
            $data['image'] = 'uploads/slider/' . $file_name;
        }

        $slider->update($data);
        session()->flash('success','Slider Updated Successfully');
        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        session()->flash('success','Slider Deleted Successfully');
        return redirect()->route('slider.index');
    }

    public function restore($id)
    {
        $slider = Slider::onlyTrashed()->findOrFail($id);
        $slider->restore();
        session()->flash('success','Slider Restored Successfully');
        return redirect()->route('slider.index');
    }

    public function delete($id)
    {
        $slider = Slider::onlyTrashed()->findOrFail($id);
        unlink($slider->image);
        $slider->forceDelete();
        session()->flash('success','Slider Permanently Removed');
        return redirect()->route('slider.index');
    }
}
