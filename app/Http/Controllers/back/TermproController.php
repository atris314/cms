<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\Termpro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TermproController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $termpros = Termpro::orderBy('id','DESC')->paginate(10);
            return view('back.termpros.termpros',compact('termpros'));
        }else{
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
            return view('back.termpros.create');
        }else{
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
            'body.required' => 'لطفا شرایط و قوانین را وارد نمایید',
        ];
        $validateData = $request->validate([
            'body' => 'required',
        ],$messages);

        $termpros = new Termpro([
            'title'     => $request->input('title'),
            'body'  => $request->input('body'),
        ]);
        //dd($emails);
        try{
            $termpros->save();
        }catch (Exception $exception){
            return redirect(route('back.termpros.create'))->with('warning',$exception->getCode());
        }
        $msg = 'شرایط و قوانین با موفقیت ایجاد شد :)' ;
        return redirect(route('back.termpros'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Termpro  $termpro
     * @return \Illuminate\Http\Response
     */
    public function show(Termpro $termpro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Termpro  $termpro
     * @return \Illuminate\Http\Response
     */
    public function edit(Termpro $termpro)
    {
        return view('back.termpros.edit',compact('termpro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Termpro  $termpro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Termpro $termpro)
    {
        $messages = [
            'body.required' => 'لطفا شرایط و قوانین را وارد نمایید',
        ];
        $validateData = $request->validate([
            'body' => 'required',
        ],$messages);

        $termpro->title = $request->input('title');
        $termpro->body = $request->input('body');
        //dd($emails);
        try{
            $termpro->update();
        }catch (Exception $exception){
            return redirect(route('back.termpros.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'شرایط و قوانین با موفقیت ویرایش شد :)' ;
        return redirect(route('back.termpros'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Termpro  $termpro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Termpro $termpro)
    {
        if (Gate::allows('isAdmin')){
            try{
                $termpro->delete();
            }catch (Exception $exception){
                return redirect(route('back.termpros'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.termpros'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
