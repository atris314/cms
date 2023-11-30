<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Catalogcat;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogcatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catclogcats = Catalogcat::orderBy('created_at','desc')->paginate(20);
        return view('back.catalogcats.catalogcats',compact('catclogcats'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catclogcats = Catalogcat::all()->pluck('title','id');
        return view('back.catalogcats.create',compact('catclogcats'));
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
            'title.required' => ' لطفا فیلد عنوان دسته بندی را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',

        ],$messages);

        $catalogcat = new Catalogcat();
        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catalogcat::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catalogcat::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catalogcat->title = $request->input('title');
        $catalogcat->catalogcat_id = $request->input('catalogcat_id');
        try{
            $catalogcat->save();
        }catch (Exception $exception){
            return redirect(route('back.catalogcats.create'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي کاتالوگ با موفقیت ایجاد شد :)' ;
        return redirect(route('back.catalogcats'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalogcat  $catalogcat
     * @return \Illuminate\Http\Response
     */
    public function show(Catalogcat $catalogcat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catalogcat  $catalogcat
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalogcat $catalogcat)
    {
        $catclogcatsub = Catalogcat::all()->pluck('title','id');
        return view('back.catalogcats.edit',compact('catclogcatsub','catalogcat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalogcat  $catalogcat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalogcat $catalogcat)
    {
        $messages = [
            'title.required' => ' لطفا فیلد عنوان دسته بندی را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Catalogcat::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Catalogcat::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $catalogcat->title = $request->input('title');
        $catalogcat->catalogcat_id = $request->input('catalogcat_id');
        try{
            $catalogcat->update();
        }catch (Exception $exception){
            return redirect(route('back.catalogcats.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي کاتالوگ با موفقیت ویرایش شد ' ;
        return redirect(route('back.catalogcats'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalogcat  $catalogcat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalogcat $catalogcat)
    {
        try{
            $catalogcat->delete();
        }catch (Exception $exception){
            return redirect(route('back.catalogcats'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندی مورد نظر حذف گردید :)' ;
        return redirect(route('back.catalogcats'))->with('success',$msg);
    }
}
