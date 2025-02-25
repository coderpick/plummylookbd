<?php

namespace App\Http\Controllers\Vendor;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function pending()
    {
        if (Auth::user()->type != 'vendor'){
            $data['title'] = 'Pending Categories';
            $data['categories'] = Category::onlyTrashed()->where('status','pending')->get();
            return view('back.vendor.category',$data);
        }
        else{
            session()->flash('error','Unauthorized Request');
            return redirect()->back();
        }
    }


    public function accept($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->update(['status'=>'active']);
        $category->restore();
        session()->flash('success','Category Suggestion Accepted');
        return redirect()->route('category.pending');
    }

    public function delete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if ($category->icon != null){
            unlink($category->icon);
        }
        $category->forceDelete();
        session()->flash('success','Category Suggestion Removed');
        return redirect()->route('category.pending');
    }
}
