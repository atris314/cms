<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Aunderwidget;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AunderwidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $aunderwidgets = Aunderwidget::orderBy('id','DESC')->paginate(30);
            return view('back.aunderwidgets.aunderwidgets',compact('aunderwidgets'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
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
            return view('back.aunderwidgets.create');
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
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
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'body.required' => ' لطفا فیلد توضیحات را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ],$messages);

        $aunderwidget = new Aunderwidget();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $aunderwidget->photo_id = $photo->id;
        }
        $aunderwidget->title = $request->input('title');
        $aunderwidget->color = $request->input('color');
        $aunderwidget->number = $request->input('number');
        $aunderwidget->body = $request->input('body');

        try{
            $aunderwidget->save();
        }catch (Exception $exception){
            return redirect(route('back.aunderwidgets.create'))->with('warning',$exception->getCode());
        }
        $msg = 'ویجت جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.aunderwidgets'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function show(Aunderwidget $aunderwidget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function edit(Aunderwidget $aunderwidget)
    {
        if (Gate::allows('isAdmin')){
            return view('back.aunderwidgets.edit',compact('aunderwidget'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aunderwidget $aunderwidget)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'body.required' => ' لطفا فیلد توضیحات را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ],$messages);

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $aunderwidget->photo_id = $photo->id;
        }
        $aunderwidget->title = $request->input('title');
        $aunderwidget->color = $request->input('color');
        $aunderwidget->number = $request->input('number');
        $aunderwidget->body = $request->input('body');
//        dd($aunderwidget);
        try{
            $aunderwidget->update();
        }catch (Exception $exception){
            return redirect(route('back.aunderwidgets.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'ویجت  با موفقیت ویرایش شد :)' ;
        return redirect(route('back.aunderwidgets'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aunderwidget $aunderwidget)
    {
        if (Gate::allows('isAdmin')){
            try{
                $aunderwidget->delete();
            }catch (Exception $exception){
                return redirect(route('back.aunderwidgets'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.aunderwidgets'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }
    }
}
