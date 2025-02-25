<?php

namespace App\Http\Controllers;

use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OfferController extends Controller
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
        Gate::authorize('app.offer.index');

        $data['title'] = 'Offer';
        $data['offers'] = Offer::withTrashed()->get();
        return view('back.offer.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.offer.index');
        $data['title'] = 'Offer';
        return view('back.offer.create',$data);
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
            'text'=>'required',
            'image'=>'required|image',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time().'fl'.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/offer/',$file_name);
            $data['image'] = 'uploads/offer/' . $file_name;
        }

        Offer::create($data);
        session()->flash('success','Offer Added Successfully');
        return redirect()->route('offer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        Gate::authorize('app.offer.index');
            $data['title'] = 'Offer Update';
            $data['offer'] = $offer;
            return view('back.offer.edit',$data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title'=>'required',
            'text'=>'required',
            'image'=>'image',
        ]);

        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time().'fl'.rand(0000,9999).$file->getClientOriginalName();
            $file->move('uploads/offer/',$file_name);
            if ($offer->image != null){
                unlink($offer->image);
            }
            $data['image'] = 'uploads/offer/' . $file_name;
        }

        $offer->update($data);
        session()->flash('success','Offer Updated Successfully');
        return redirect()->route('offer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        session()->flash('success','Offer Deleted Successfully');
        return redirect()->route('offer.index');
    }

    public function restore($id)
    {
        $offer = Offer::onlyTrashed()->findOrFail($id);
        $offer->restore();
        session()->flash('success','Offer Restored Successfully');
        return redirect()->route('offer.index');
    }

    public function delete($id)
    {
        $offer = Offer::onlyTrashed()->findOrFail($id);
        unlink($offer->image);
        $offer->forceDelete();
        session()->flash('success','Offer Permanently Removed');
        return redirect()->route('offer.index');
    }
}
