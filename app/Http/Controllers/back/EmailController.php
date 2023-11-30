<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $emails = Email::orderBy('id','DESC')->paginate(10);
            return view('back.emails.emails',compact('emails'));
        }else
        {
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('isAdmin')){
            return view('back.emails.create');
        }else
        {
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }

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
            'email.required' => 'لطفا نشانی ایمیل مورد نظرتان را وارد کنید',
        ];
        $validateData = $request->validate([
            'email' => 'required',
        ],$messages);

        $emails = new Email([
            'name'     => $request->input('name'),
            'email'  => $request->input('email'),
        ]);
        //dd($emails);
        try{
            $emails->save();
        }catch (Exception $exception){
            return redirect(route('back.emails.create'))->with('warning',$exception->getCode());
        }
        $msg = 'ایمیل جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.emails'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        if (Gate::allows('isAdmin'))
        {
            return view('back.emails.edit',compact('email'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        $messages = [
            'email.required' => 'لطفا نشانی ایمیل مورد نظرتان را وارد کنید',
        ];
        $validateData = $request->validate([
            'email' => 'required',
        ],$messages);

            $email->name = $request->input('name');
            $email->email = $request->input('email');
        //dd($emails);
        try{
            $email->update();
        }catch (Exception $exception){
            return redirect(route('back.emails.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'ایمیل با موفقیت ویرایش شد :)' ;
        return redirect(route('back.emails'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        if (Gate::allows('isAdmin')){
            try{
                $email->delete();
            }catch (Exception $exception){
                return redirect(route('back.emails'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.emails'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
