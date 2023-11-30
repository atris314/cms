<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Photo;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $abouts = About::OrderBy('id','DESC')->paginate(5);
            return view('back.abouts.abouts',compact('abouts'));
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
            return view('back.abouts.create');
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
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'top_description.required' => ' لطفا فیلد متن بالای درباره ما را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'top_description' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $about = new About();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $about->photo_id = $photo->id;
        }


        $about->title = $request->input('title');
        $about->top_description = $request->input('top_description');
//dd($post);

        try{
            $about->save();
        }catch (Exception $exception){
            return redirect(route('back.abouts.create'))->with('warning',$exception->getCode());
        }
        $msg = 'درباره ما با موفقیت ایجاد شد :)' ;
        return redirect(route('back.abouts'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about)
    {
        if (Gate::allows('isAdmin')){
            return view('back.abouts.edit',compact('about'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, About $about)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
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
            $about->photo_id = $photo->id;
        }


        $about->title = $request->input('title');
        $about->top_description = $request->input('top_description');
//dd($about);
        try{
            $about->update();
        }catch (Exception $exception){
            return redirect(route('back.abouts.edit',$about->id))->with('warning',$exception->getCode());
        }
        $msg = 'درباره ما با موفقیت ویرایش شد :)' ;
        return redirect(route('back.abouts'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        if (Gate::allows('isAdmin')){
            try{
                $about->delete();
            }catch (Exception $exception){
                return redirect(route('back.abouts'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.abouts'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
