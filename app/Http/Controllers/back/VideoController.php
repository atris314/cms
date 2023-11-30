<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderBy('created_at','desc')->paginate(30);
        return view('back.videos.videos',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.videos.create');
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
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);


        $video = new Video();



        $video->title = $request->input('title');
        $video->script = $request->input('script');

        try{
            $video->save();
        }catch (Exception $exception){
            return redirect(route('back.videos.create'))->with('warning',$exception->getCode());
        }
        $msg = 'ویدئو با موفقیت ایجاد شد :)' ;
        return redirect(route('back.videos'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('back.videos.edit',compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {

        $video->title = $request->input('title');
        $video->script = $request->input('script');

        try{
            $video->update();
        }catch (Exception $exception){
            return redirect(route('back.videos.edit',$video->id))->with('warning',$exception->getCode());
        }
        $msg = 'ویدئو با موفقیت ویرایش شد :)' ;
        return redirect(route('back.videos'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        try{
            $video->delete();
        }catch (Exception $exception){
            return redirect(route('back.videos'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.videos'))->with('success',$msg);
    }
}
