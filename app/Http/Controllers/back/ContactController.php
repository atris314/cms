<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('id','DESC')->paginate(10);
        return view('back.contacts.contacts',compact('contacts'));
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
        //
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
        return view('back.contacts.edit',compact('contact'));
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
        $messages = [
            'body.required' => ' لطفا فیلد متن را وارد نمایید',

        ];
        $validateData = $request->validate([
            'body' => 'required',
        ],$messages);


        try{
            $contact->update($request->all());
        }catch (Exception $exception){
            return redirect(route('back.contacts.edit'))->with('warning',$exception->getCode());
        }

        $msg = 'ويرايش تماس با موفقیت انجام شد ' ;
        return redirect(route('back.contacts'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        try{
            $contact->delete();
        }catch (Exception $exception){
            return redirect(route('back.contacts'))->with('warning',$exception->getCode());
        }
        $msg = 'تماس كاربر مورد نظر حذف گردید :)' ;
        return redirect(route('back.contacts'))->with('success',$msg);
    }

    public function updatestatus(Contact $contact)
    {
        if ($contact->status==1)
        {
            $contact->status = 0;
        }else
        {
            $contact->status = 1;
        }
        $contact->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.contacts'))->with('success',$msg);
    }
}
