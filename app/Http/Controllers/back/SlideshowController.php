<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Slideshow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slideshows = Slideshow::orderBy('created_at','desc')->paginate(20);
        return view('back.slideshows.slideshows',compact('slideshows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.slideshows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slideshow = new Slideshow();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $slideshow->photo_id = $photo->id;
        }
        $slideshow->alt = $request->input('alt');
        try{
            $slideshow->save();
        }catch (Exception $exception){
            return redirect(route('back.slideshows.create'))->with('warning',$exception->getCode());
        }
        $msg = ' با موفقیت ایجاد شد :)' ;
        return redirect(route('back.slideshows'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function show(Slideshow $slideshow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function edit(Slideshow $slideshow)
    {
        return view('back.slideshows.edit',compact('slideshow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slideshow $slideshow)
    {
        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $slideshow->photo_id = $photo->id;
        }
        $slideshow->alt = $request->input('alt');
        try{
            $slideshow->update();
        }catch (Exception $exception){
            return redirect(route('back.slideshows.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' با موفقیت ویرایش شد :)' ;
        return redirect(route('back.slideshows'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slideshow $slideshow)
    {
        try{
            $slideshow->delete();
        }catch (Exception $exception){
            return redirect(route('back.slideshows'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.slideshows'))->with('success',$msg);
    }
}
