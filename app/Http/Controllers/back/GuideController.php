<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guides = Guide::orderBy('created_at','DESC')->paginate(20);
        return view('back.guides.guides',compact('guides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.guides.create');
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
            'photo_id.required' => ' لطفا تصویر را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'photo_id' => 'required|file|image|mimes:jpeg,pngmgif,webp,mp4,webm,ogv|maz:10gig',
        ],$messages);


        $guide = new Guide();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $guide->photo_id = $photo->id;
        }
        dd($photo);

        $guide->title = $request->input('title');
        $guide->link= $request->input('link');


        try{
            $guide->save();
        }catch (Exception $exception){
            return redirect(route('back.guides.create'))->with('warning',$exception->getCode());
        }
        $msg = 'راهنمای ثبت سفارش با موفقیت ایجاد شد :)' ;
        return redirect(route('back.guides'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function edit(Guide $guide)
    {
        return view('back.guides.edit',compact('guide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guide $guide)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'photo_id' => 'required',
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
            $guide->photo_id = $photo->id;
        }


        $guide->title = $request->input('title');
        $guide->link= $request->input('link');


        try{
            $guide->update();
        }catch (Exception $exception){
            return redirect(route('back.guides.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'راهنمای ثبت سفارش با موفقیت ویرایش شد :)' ;
        return redirect(route('back.guides'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guide $guide)
    {
        if (Gate::allows('isAdmin')){
            try{
                $guide->delete();
            }catch (Exception $exception){
                return redirect(route('back.guides'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید' ;
            return redirect(route('back.guides'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
