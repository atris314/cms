<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Catalogcat;
use App\Models\Photo;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogs = Catalog::orderby('created_at','desc')->paginate(20);
        return view('back.catalogs.catalogs',compact('catalogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catalogcats = Catalogcat::all()->pluck('title','id');
        return view('back.catalogs.create',compact('catalogcats'));
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
//        dd($request);

        $catalog = new Catalog();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $catalog->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catalog::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catalog::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catalog->title = $request->input('title');
        $catalog->link = $request->input('link');
        $catalog->price = $request->input('price');
        $catalog->body = $request->input('body');
        $catalog->description = $request->input('description');
        $catalog->keyword = $request->input('keyword');
        $catalog->status = $request->input('status');
        $catalog->catalogcat_id = $request->input('catalogcat_id');

        try{
            $catalog->save();
        }catch (Exception $exception){
            return redirect(route('back.catalogs.create'))->with('warning',$exception->getCode());
        }
        $msg = 'کاتالوگ جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.catalogs'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
    {
        $catalogcats = Catalogcat::all()->pluck('title','id');
//        dd($catalog);
        return view('back.catalogs.edit',compact('catalogcats','catalog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);
//        dd($request);


        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $catalog->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catalog::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catalog::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catalog->title = $request->input('title');
        $catalog->link = $request->input('link');
        $catalog->price = $request->input('price');
        $catalog->body = $request->input('body');
        $catalog->description = $request->input('description');
        $catalog->keyword = $request->input('keyword');
        $catalog->status = $request->input('status');
        $catalog->catalogcat_id = $request->input('catalogcat_id');

        try{
            $catalog->update();
        }catch (Exception $exception){
            return redirect(route('back.catalogs.edit',$catalog->slug))->with('warning',$exception->getCode());
        }
        $msg = 'کاتالوگ با موفقیت ویرایش شد :)' ;
        return redirect(route('back.catalogs'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        try{
            $catalog->delete();
        }catch (Exception $exception){
            return redirect(route('back.catalogs'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.catalogs'))->with('success',$msg);
    }
    public function updatestatus(Catalog $catalog)
    {
        if ($catalog->status==1)
        {
            $catalog->status = 0;
        }else
        {
            $catalog->status = 1;
        }
        $catalog->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.catalogs'))->with('success',$msg);
    }

    public function CatalogSent(Catalog $catalog)
    {
        dd($catalog);

//            for($i=0; $i<count($emailaddress); $i++){
//                Mail::to(['farinaz.haghighi314@gmail.com',$emailaddress[$i]])
//                    ->send(new Emailmarke($emailmarketing,$photo));
//            }

//        $msg = 'کاتالوگ جدید با موفقیت ارسال شد شد :)' ;
//        return redirect(route('back.catalogs'))->with('success',$msg);
    }
}
