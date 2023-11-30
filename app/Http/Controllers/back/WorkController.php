<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Photo;
use App\Models\Work;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('isAdmin')){
            $works =  Work::orderBy('id','DESC')->paginate(10);
            return view('back.works.works',compact('works'));
        }
        else{
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
        if(Gate::allows('isAdmin')){
            return view('back.works.create');
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
            'title.required' => ' لطفا فیلد عنوان را وارد نمایید',
            'body.required' => ' لطفا فیلد شرایط و قوانین را تکمیل کنید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $works = new Work();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $works->photo_id = $photo->id;
        }


        $works->title = $request->input('title');
        $works->body = $request->input('body');
//dd($post);

        try{
            $works->save();
        }catch (Exception $exception){
            return redirect(route('back.works.create'))->with('warning',$exception->getCode());
        }
        $msg = 'همکاری با ما با موفقیت ایجاد شد :)' ;
        return redirect(route('back.works'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        if (Gate::allows('isAdmin')){
            return view('back.works.edit',compact('work'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        $messages = [
            'title.required' => ' لطفا فیلد عنوان را وارد نمایید',
            'body.required' => ' لطفا فیلد شرایط و قوانین را تکمیل کنید',
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
            $work->photo_id = $photo->id;
        }


        $work->title = $request->input('title');
        $work->body = $request->input('body');

        try{
            $work->update();
        }catch (Exception $exception){
            return redirect(route('back.works.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'همکاری با ما با موفقیت ویرایش شد :)' ;
        return redirect(route('back.works'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        if (Gate::allows('isAdmin')){
            try{
                $work->delete();
            }catch (Exception $exception){
                return redirect(route('back.works'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.works'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
