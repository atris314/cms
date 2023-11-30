<?php

namespace App\Http\Controllers\front;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\frontmodels\Contact;
use App\Mail\ContactSent;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Trez\RayganSms\Facades\RayganSms;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.contact');
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
            'name.required' => ' لطفا نام را وارد نمایید',
            'email.required' => ' لطفا ایمیل را وارد نمایید',
            'body.required' => ' لطفا متن تماس خود را وارد نمایید',

        ];
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'body' => 'required',
//            'arcaptcha-token' => 'arcaptcha',
        ],$messages);

        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->mobile = $request->input('mobile');
        $contact->subject = $request->input('subject');
        $contact->body = $request->input('body');

//        Mail::to($request->email)
//            ->send(new ContactSent($request));
//        RayganSms::sendMessage('0936*******','Test Message');

//        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//        $api->SendSimple(
//            "09370068263",  // receptor
//            "تماس شما دریافت شد", // message
//            "10008566"    // choose a line number from your account
//        );
        try{
            $contact->save();
        }catch (Exception $exception){
            return redirect()->back()->with('warning',$exception->getCode());
        }
        $msg = 'پيام شما با موفقيت ثبت شد. از اينكه ما را انتخاب نموده ايد سپاسگزاريم' ;
        return redirect()->back()->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
