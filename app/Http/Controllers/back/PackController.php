<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Pack;

use App\Models\Photo;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $packs = Pack::with('photo')->orderBy('id','DESC')->paginate(10);
            //dd($packs);
            return view('back.packs.packs',compact('packs'));
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
            return view('back.packs.create');
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
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'photo_id.required' => ' آپلود عکس الزامی می باشد',
            'deacription.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'price.required' => ' لطفا فیلد قیمت را وارد نمایید',
            'price.integer' => ' قیمت باید به صورت عددی و انگلیسی وارد شود',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'price' => 'required|integer',
            'description' => 'required',
            'photo_id' => 'required',
        ],$messages);

        $pack = new Pack();
        $photo = $pack->photo();
        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $pack->photo_id = $photo->id;
        }

        $pack->title = $request->input('title');
        $pack->price = $request->input('price');
        $pack->status = $request->input('status');
        $pack->description = $request->input('description');


        try{
            $pack->save();
        }catch (Exception $exception){
            return redirect(route('back.packs.create'))->with('warning',$exception->getCode());
        }
        $msg = ' تعرفه جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.packs'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function show(Pack $pack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function edit(Pack $pack)
    {
        if (Gate::allows('isAdmin')){
            return view('back.packs.edit',compact('pack'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pack $pack)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'photo_id.required' => ' آپلود عکس الزامی می باشد',
            'deacription.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'price.required' => ' لطفا فیلد قیمت را وارد نمایید',
            'price.integer' => ' قیمت باید به صورت اعداد انگلیسی وارد شود',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'price' => 'required|integer',
            'description' => 'required',
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
            $pack->photo_id = $photo->id;

        }

        $pack->title = $request->input('title');
        $pack->price = $request->input('price');
        $pack->status = $request->input('status');
        $pack->description = $request->input('description');

        try{
            $pack->update();
        }catch (Exception $exception){
            return redirect(route('back.packs.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' تعرفه با موفقیت ویرایش شد :)' ;
        return redirect(route('back.packs'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pack $pack)
    {
        if (Gate::allows('isAdmin')){
            try{
                $pack->delete();
            }catch (Exception $exception){
                return redirect(route('back.packs'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.packs'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }

    }
    public function updatestatus(Pack $pack)
    {
        if ($pack->status==1)
        {
            $pack->status = 0;
        }else
        {
            $pack->status = 1;
        }
        $pack->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.packs'))->with('success',$msg);

    }
}
