<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::orderBy('created_at','desc')->paginate(30);
        return view('back.galleries.galleries',compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.galleries.create');
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
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $gallery = new Gallery();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $gallery->photo_id = $photo->id;
        }
        $photos = explode(',', $request->input('photos')[0]);
        $gallery->title = $request->input('title');

        try{
            $gallery->save();
            if (isset($request->input('photos')[0])){
                $gallery->photos()->sync($photos);
            }

        }catch (Exception $exception){
            return redirect(route('back.galleries.create'))->with('warning',$exception->getCode());
        }
        $msg = 'گالری با موفقیت ایجاد شد :)' ;
        return redirect(route('back.galleries'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        return view('back.galleries.edit',compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {

        $messages = [
            'title.required' => ' لطفا فیلد عنوان را وارد نمایید',
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
            $gallery->photo_id = $photo->id;
        }
        $photos = explode(',', $request->input('photos')[0]);

        $gallery->title = $request->input('title');

        try{
            $gallery->update();
            if (isset($request->input('photos')[0])) {
                $gallery->photos()->sync($photos);
            }
        }catch (Exception $exception){
            return redirect(route('back.galleries.edit',compact($gallery->id)))->with('warning',$exception->getCode());
        }
        $msg = 'گالری با موفقیت ویرایش شد :)' ;
        return redirect(route('back.galleries'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        try{
            $gallery->delete();
        }catch (Exception $exception){
            return redirect(route('back.galleries'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.galleries'))->with('success',$msg);
    }
}
