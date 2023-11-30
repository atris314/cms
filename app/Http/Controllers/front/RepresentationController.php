<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Representation;
use App\Models\Widget;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class RepresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $widgets = Widget::first();

        return view('front.representations',compact('widgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name.required' => ' لطفا فیلد نام را وارد نمایید',
            'email.required' => ' لطفا ایمیل خود را وارد نمایید',
            'phone.required' => ' لطفا شماره تماس خود را وارد نمایید',
            'photo_id.required' => ' لطفا رزومه خود را ارسال کنید',
        ];
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $representation = new Representation();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $representation->photo_id = $photo->id;
        }

        $representation->name = $request->input('name');
        $representation->email = $request->input('email');
        $representation->phone = $request->input('phone');
        $representation->description = $request->input('description');
        $representation->status = 0 ;

        try{
            $representation->save();
        }catch (Exception $exception){
            return redirect(route('representations'))->with('warning',$exception->getCode());
        }
        $msg = 'درخواست شما با موفقیت ارسال شد' ;
        return redirect(route('representations'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function show(Representation $representation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function edit(Representation $representation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Representation $representation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Representation $representation)
    {
        //
    }
}
