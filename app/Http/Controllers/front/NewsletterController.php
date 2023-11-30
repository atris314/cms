<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Contact;
use App\Http\Controllers\Controller;
use App\Mail\ContactSent;
use App\frontmodels\Newsletter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $messages = [
            'mobile.required' => ' لطفا ایمیل را وارد نمایید',
        ];
        $validateData = $request->validate([
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
        ],$messages);

        $newsletter = new Newsletter();
        $newsletter->mobile = $request->mobile;
        try{
        $newsletter->save();
        }
        catch (Exception $exception){
            return redirect(route('product'))->with('news',$exception->getCode());
        }
        $msg = 'عضویت در خبرنامه با موفقیت انجام شد.' ;
        return back()->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        //
    }
}
