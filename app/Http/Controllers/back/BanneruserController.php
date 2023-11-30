<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Banneruser;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BanneruserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bannerusers = Banneruser::orderBy('created_at','DESC')->paginate(20);
        return view('back.bannerusers.bannerusers',compact('bannerusers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.bannerusers.create');
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
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $banneruser = new Banneruser();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $banneruser->photo_id = $photo->id;
        }


        $banneruser->title = $request->input('title');


        try{
            $banneruser->save();
        }catch (Exception $exception){
            return redirect(route('back.bannerusers.create'))->with('warning',$exception->getCode());
        }
        $msg = 'بنر با موفقیت ایجاد شد :)' ;
        return redirect(route('back.bannerusers'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banneruser  $banneruser
     * @return \Illuminate\Http\Response
     */
    public function show(Banneruser $banneruser)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banneruser  $banneruser
     * @return \Illuminate\Http\Response
     */
    public function edit(Banneruser $banneruser)
    {
        return view('back.bannerusers.edit',compact('banneruser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banneruser  $banneruser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banneruser $banneruser)
    {
        $messages = [

        ];
        $validateData = $request->validate([

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
            $banneruser->photo_id = $photo->id;
        }

        $banneruser->title = $request->input('title');

        try{
            $banneruser->save();
        }catch (Exception $exception){
            return redirect(route('back.bannerusers.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'بنر با موفقیت ویرایش شد :)' ;
        return redirect(route('back.bannerusers'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banneruser  $banneruser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banneruser $banneruser)
    {
        if (Gate::allows('isAdmin')){
            try{
                $banneruser->delete();
            }catch (Exception $exception){
                return redirect(route('back.bannerusers'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.bannerusers'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
