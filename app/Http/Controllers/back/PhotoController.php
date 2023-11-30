<?php

namespace App\Http\Controllers\back;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $photos = Photo::with('user')->orderBy('id','DESC')->paginate(10);
            return view('back.photos.photos',compact('photos'));
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
            return view('back.photos.create');
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
        $file = $request->file('file');

        $name = time().$file->getClientOriginalName();
        $files= $file->move(public_path('images'),$name);
        $photo = new Photo();
        $photo->name =$files;
        $photo->path = $name;
        $photo->user_id = Auth::id();

        $photo ->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        if (Gate::allows('isAdmin')){
            try{
                $photo->delete();
            }catch (Exception $exception){
                return redirect(route('back.photos'))->with('warning',$exception->getCode());
            }
            $msg = 'فایل با موفقیت حذف شد' ;
            return redirect(route('back.photos'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر اجازه حذف رسانه را دارد.' ;
            return back()->with('info',$msg);
        }

    }

    public function upload(Request $request)
    {
        //dd('hello');
//        $uploadedfile= $request->file('file');
//        $filename = time() . $uploadedfile->getClientOriginalName();
//        $name = $uploadedfile->getClientOriginalName();
//
//        Storage::disk('local')->putFileAs(
//            'images/', $uploadedfile , $filename
//        );
//        $photo = new Photo();
//        $photo->name = $name;
//        $photo->path =$filename;
//        $photo->user_id = Auth::user()->id;
//        $photo->save();

        $file = $request->file('file');

        $name = time().$file->getClientOriginalName();
        $files= $file->move(public_path('images'),$name);
        $photo = new Photo();
        $photo->name =$files;
        $photo->path = $name;
        $photo->user_id = Auth::id();
        $photo ->save();

        return response()->json([
            'photos' =>$photo->id
        ]);
    }

    public function deleteAll(Request $request)
    {
        $photos = Photo::findOrFail($request->checkBoxArray);
        foreach ($photos as $photo){
            unlink(public_path() . $photo->path);
            $photo->delete();
        }
        $msg = 'فایل ها با موفقیت حذف شد' ;
        return redirect(route('back.photos'))->with('success',$msg);
    }

}
