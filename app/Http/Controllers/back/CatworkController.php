<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Catorder;
use App\Models\Catwork;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CatworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $catworks = Catwork::orderBy('id','DESC')->paginate(10);
            return view('back.catworks.catworks',compact('catworks'));
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
            $catworkstop = Catwork::all()->pluck('title','id');
            return view('back.catworks.create',compact('catworkstop'));
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

        $catwork = new Catwork();

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catwork::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catwork::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);
        $catwork->title = $request->input('title');
        $catwork->catwork_id = $request->input('catwork_id');

        try{
            $catwork->save();
        }catch (Exception $exception){
            return redirect(route('back.catworks.create'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.catworks'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catwork  $catwork
     * @return \Illuminate\Http\Response
     */
    public function show(Catwork $catwork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catwork  $catwork
     * @return \Illuminate\Http\Response
     */
    public function edit(Catwork $catwork)
    {
        if (Gate::allows('isAdmin')){
            $catworksub = Catwork::all()->pluck('title','id');
            return view('back.catworks.edit',compact('catwork','catworksub'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catwork  $catwork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catwork $catwork)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catwork::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catwork::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);
        $catwork->title = $request->input('title');
        $catwork->catwork_id = $request->input('catwork_id');

        try{
            $catwork->update();
        }catch (Exception $exception){
            return redirect(route('back.catworks.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ویرایش شد :)' ;
        return redirect(route('back.catworks'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catwork  $catwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catwork $catwork)
    {
        if (Gate::allows('isAdmin')){
            try{
                $catwork->delete();
            }catch (Exception $exception){
                return redirect(route('back.catworks'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.catworks'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }
    }
}
