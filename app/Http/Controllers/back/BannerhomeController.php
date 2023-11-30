<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Bannerhome;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerhomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bannerhomes = Bannerhome::orderBy('created_at','desc')->paginate(120);
        return view('back.bannerhomes.bannerhomes',compact('bannerhomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.bannerhomes.create');
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
            'alt.required' => ' لطفا فیلد alt را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'alt' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $bannerhome = new Bannerhome();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $bannerhome->photo_id = $photo->id;
        }


        $bannerhome->alt = $request->input('alt');
        $bannerhome->button = $request->input('button');
        $bannerhome->link = $request->input('link');
        $bannerhome->status = $request->input('status');

//        dd($bannerhome);
        try{
            $bannerhome->save();
        }catch (Exception $exception){
            return redirect(route('back.bannerhomes.create'))->with('warning',$exception->getCode());
        }
        $msg = 'بنر با موفقیت ایجاد شد :)' ;
        return redirect(route('back.bannerhomes'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bannerhome  $bannerhome
     * @return \Illuminate\Http\Response
     */
    public function show(Bannerhome $bannerhome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bannerhome  $bannerhome
     * @return \Illuminate\Http\Response
     */
    public function edit(Bannerhome $bannerhome)
    {
        return view('back.bannerhomes.edit',compact('bannerhome'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bannerhome  $bannerhome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bannerhome $bannerhome)
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
            $bannerhome->photo_id = $photo->id;
        }
        $bannerhome->alt = $request->input('alt');
        $bannerhome->button = $request->input('button');
        $bannerhome->link = $request->input('link');
        $bannerhome->status = $request->input('status');


        try{
            $bannerhome->update();
        }catch (Exception $exception){
            return redirect(route('back.bannerhomes.edit',$bannerhome->id))->with('warning',$exception->getCode());
        }
        $msg = 'بنر با موفقیت ویرایش شد :)' ;
        return redirect(route('back.bannerhomes'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bannerhome  $bannerhome
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bannerhome $bannerhome)
    {
        try{
            $bannerhome->delete();
        }catch (Exception $exception){
            return redirect(route('back.bannerhomes'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.bannerhomes'))->with('success',$msg);
    }
    public function updatestatus(Bannerhome $bannerhome)
    {
        if ($bannerhome->status==1)
        {
            $bannerhome->status = 0;
        }else
        {
            $bannerhome->status = 1;
        }
        $bannerhome->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.bannerhomes'))->with('success',$msg);

    }
}
