<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Catslider;
use App\Models\Photo;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatsliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catsliders = Catslider::orderBy('id','DESC')->paginate(10);
        return view('back.catsliders.catsliders',compact('catsliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catsliderstop = Catslider::all()->pluck('title','id');
        return view('back.catsliders.create',compact('catsliderstop'));
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


        $catslider = new Catslider();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $catslider->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catslider::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catslider::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catslider->title = $request->input('title');
        $catslider->meta_description = $request->input('meta_description');
        $catslider->meta_keywords = $request->input('meta_keywords');
        $catslider->catslider_id = $request->input('catslider_id');
        $catslider->color = $request->input('color');
//        dd($catslider);
        try{
            $catslider->save();
        }catch (Exception $exception){
            return redirect(route('back.catsliders.create'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.catsliders'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catslider  $catslider
     * @return \Illuminate\Http\Response
     */
    public function show(Catslider $catslider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catslider  $catslider
     * @return \Illuminate\Http\Response
     */
    public function edit(Catslider $catslider)
    {
        $catsliderstop = Catslider::all()->pluck('title','id');

        return view('back.catsliders.edit',compact('catsliderstop','catslider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catslider  $catslider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catslider $catslider)
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
            $catslider->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catslider::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catslider::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catslider->title = $request->input('title');
        $catslider->meta_description = $request->input('meta_description');
        $catslider->meta_keywords = $request->input('meta_keywords');
        $catslider->catslider_id = $request->input('catslider_id');
        $catslider->color = $request->input('color');
        try{
            $catslider->save();
        }catch (Exception $exception){
            return redirect(route('back.catsliders.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ویرایش شد :)' ;
        return redirect(route('back.catsliders'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catslider  $catslider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catslider $catslider)
    {
        try{
            $catslider->delete();
        }catch (Exception $exception){
            return redirect(route('back.catsliders'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.catsliders'))->with('success',$msg);
    }
}
