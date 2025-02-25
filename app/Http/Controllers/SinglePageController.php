<?php

namespace App\Http\Controllers;

use App\About;
use App\Contact;
use App\Privacy;
use App\Team;
use Illuminate\Http\Request;

class SinglePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        $data['title'] = 'Contact Us';
        $data['contact'] = Contact::latest()->first();
        return view('front.contact',$data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        $data['title'] = 'Privacy Policy';
        $data['privacies'] = Privacy::latest()->first();
        return view('front.privacy',$data);
    }

    public function cookies()
    {
        $data['title'] = 'Cookies Policy';
        $data['cookies'] = Privacy::latest()->first();
       return view('front.privacy',$data);
    }

    public function terms()
    {
        $data['title'] = 'Terms & Condition';
        $data['terms'] = Privacy::latest()->first();
       return view('front.privacy',$data);
    }

    public function faq()
    {
        $data['title'] = "FAQ's";
        $data['faq'] = Privacy::latest()->first();
        return view('front.privacy',$data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
