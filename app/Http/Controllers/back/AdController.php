<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Ad;
use App\Models\Catorder;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $ads = Ad::orderBy('created_at','DESC')->paginate(20);
            return view('back.ads.ads',compact('ads'));
        }else{
            $msg = 'شما به این بخش دسترسی ندارید.' ;
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
            $catorders =Catorder::all()->pluck('title','id');
            return view('back.ads.create',compact('catorders'));
        }else{
            $msg = 'شما به این بخش دسترسی ندارید.' ;
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
            'link.required' => ' لطفا لینک را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'link' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $ad = new Ad();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $ad->photo_id = $photo->id;
        }


        $ad->title = $request->input('title');
        $ad->link = $request->input('link');
        $ad->catorder_id = $request->input('catorder_id');
        $ad->description = $request->input('description');
        //dd($ad);

        try{
            $ad->save();
        }catch (Exception $exception){
            return redirect(route('back.ads.create'))->with('warning',$exception->getCode());
        }
        $msg = ' تبلغیات جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.ads'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        if (Gate::allows('isAdmin')){
            $catorders =Catorder::all()->pluck('title','id');
            return view('back.ads.edit',compact('ad','catorders'));
        }else{
            $msg = 'شما به این بخش دسترسی ندارید.' ;
            return back()->with('info',$msg);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $messages = [
            'link.required' => ' لطفا لینک را وارد نمایید',
        ];
        $validateData = $request->validate([
            'link' => 'required',
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
            $ad->photo_id = $photo->id;
        }


        $ad->title = $request->input('title');
        $ad->link = $request->input('link');
        $ad->catorder_id = $request->input('catorder_id');
        $ad->description = $request->input('description');
        //dd($ad);

        try{
            $ad->update();
        }catch (Exception $exception){
            return redirect(route('back.ads.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' تبلغیات جدید با موفقیت ویرایش شد :)' ;
        return redirect(route('back.ads'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        if (Gate::allows('isAdmin')){
            try{
                $ad->delete();
            }catch (Exception $exception){
                return redirect(route('back.ads'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.ads'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
