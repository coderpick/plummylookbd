<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function banner_image()
    {
        return view('back.banner_content');
    }
    public function banner_imageUpdate(Request $request)
    {
        $this->validate($request,[
            'site_flash_sale_img' => 'required|image',
            /*'site_featured_img' => 'required|image',*/
        ]);

        if ($request->hasFile('site_flash_sale_img')){
            $file = $request->file('site_flash_sale_img');
            $file_name = time().rand(0000,9999).'.'.$file->getClientoriginalExtension();
            if(setting('site_flash_sale_img')){
                unlink(setting('site_flash_sale_img'));
            }
            $file->move('uploads/about_img/',$file_name);
            Setting::updateOrCreate(
                ['name' => 'site_flash_sale_img'],
                ['value'=>'uploads/about_img/' . $file_name]
            );
        }

       /* if ($request->hasFile('site_featured_img')){
            $file = $request->file('site_featured_img');
            $file_name = time().rand(0000,9999).'.'.$file->getClientoriginalExtension();
            if(setting('site_featured_img')){
                unlink(setting('site_featured_img'));
            }
            $file->move('uploads/about_img/',$file_name);
            Setting::updateOrCreate(
                ['name' => 'site_featured_img'],
                ['value'=>'uploads/about_img/' . $file_name]
            );
        }*/

        session()->flash('success','Banner Images Updated Successfully');
        return redirect()->back();

    }
}
