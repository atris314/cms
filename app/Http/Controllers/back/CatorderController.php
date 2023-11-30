<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Catorder;
use App\Models\Photo;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CatorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $catorders = Catorder::orderBy('id','DESC')->paginate(10);
            return view('back.catorders.catorders',compact('catorders'));
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
            $catorderstop = Catorder::all()->pluck('title','id');
            return view('back.catorders.create',compact('catorderstop'));
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


        ];
        $validateData = $request->validate([
            'title' => 'required',

        ],$messages);


        $catorder = new Catorder();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $catorder->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catorder::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catorder::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catorder->title = $request->input('title');
        $catorder->meta_description = $request->input('meta_description');
        $catorder->meta_keywords = $request->input('meta_keywords');
        $catorder->catorder_id = $request->input('catorder_id');
        $catorder->color = $request->input('color');
        $catorder->status = $request->input('status');
        try{
            $catorder->save();
        }catch (Exception $exception){
            return redirect(route('back.catorders.create'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.catorders'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catorder  $catorder
     * @return \Illuminate\Http\Response
     */
    public function show(Catorder $catorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catorder  $catorder
     * @return \Illuminate\Http\Response
     */
    public function edit(Catorder $catorder)
    {
        if (Gate::allows('isAdmin')){
            $catordersub = Catorder::all()->pluck('title','id');
            return view('back.catorders.edit',compact('catorder','catordersub'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catorder  $catorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catorder $catorder)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',

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
            $catorder->photo_id = $photo->id;
        }
        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catorder::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catorder::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catorder->title = $request->input('title');
        $catorder->meta_description = $request->input('meta_description');
        $catorder->meta_keywords = $request->input('meta_keywords');
        $catorder->catorder_id = $request->input('catorder_id');
        $catorder->color = $request->input('color');
        $catorder->status = $request->input('status');
//        dd($catorder);
        try{
            $catorder->update();
        }catch (Exception $exception){
            return redirect(route('back.catorders.create'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.catorders'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catorder  $catorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catorder $catorder)
    {
        if (Gate::allows('isAdmin')){
            try{
                $catorder->delete();
            }catch (Exception $exception){
                return redirect(route('back.catorders'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.catorders'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }

    }
    public function updatestatus(Catorder $catorder)
    {
        if ($catorder->status==1)
        {
            $catorder->status = 0;
        }else
        {
            $catorder->status = 1;
        }
        $catorder->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.catorders'))->with('success',$msg);
    }
}
