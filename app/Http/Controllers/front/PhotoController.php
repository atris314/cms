<?php

namespace App\Http\Controllers\front;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

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




}
