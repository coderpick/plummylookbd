<?php

namespace App\Http\Controllers;

use App\StaticReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StaticReviewController extends Controller
{
    public function index()
    {
       // Gate::authorize('app.stReview.index');
        $data['title'] = 'Static Review';
        $data['reviews'] = StaticReview::paginate(10);
        return view('back.static_review.index',$data);
    }

    public function create()
    {
       // Gate::authorize('app.stReview.index');
        $data['title'] = 'Static Review';
        return view('back.static_review.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'rating'=>'required',
            'review'=>'required',
        ]);
        $data = $request->except('_token');

        StaticReview::create($data);
        session()->flash('success','Review Created Successfully');
        return redirect()->route('static-review.index');
    }

    public function show(StaticReview $review)
    {
        //
    }

    public function edit($id)
    {
        $data['title'] = 'Review';
        $data['review'] = StaticReview::where('id', $id)->first();
        return view('back.static_review.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'rating'=>'required',
            'review'=>'required',
        ]);

        $data = $request->except('_token');

        $review = StaticReview::where('id', $id)->first();
        $review->update($data);

        session()->flash('success','Review Updated Successfully');
        return redirect()->route('static-review.index');
    }

    public function destroy($slug)
    {
        $review = StaticReview::where('id', $slug)->first();
        $review->delete();
        session()->flash('success','Review Deleted Successfully');
        return redirect()->route('static-review.index');
    }
}
