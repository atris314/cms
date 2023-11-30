<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $categories = Category::OrderBy('id' ,'DESC')->paginate(10);
            return view('back.categories.categories',compact('categories'));
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
            $cattop = Category::all()->pluck('title','id');
            return view('back.categories.create',compact('cattop'));
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
            'meta_description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'meta_keywords.required' => ' لطفا فیلد توضیحات را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ],$messages);


        $category = new Category();

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Category::class, 'slug', $request->title );
        }else
        {
            $slug = SlugService::createSlug(Category::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);


        $category->title = $request->input('title');
        $category->meta_description = $request->input('meta_description');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->category_id = $request->input('category_id');
        try{
            $category->save();
        }catch (Exception $exception){
            return redirect(route('back.categories.create'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.categories'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (Gate::allows('isAdmin')){
            $catsub = Category::all()->pluck('title','id');
            return view('back.categories.edit',compact('category','catsub'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'meta_description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'meta_keywords.required' => ' لطفا فیلد توضیحات را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
        ],$messages);

//
//        if(empty($request->slug))
//        {
//            $slug = SlugService::createSlug(Category::class, 'slug', $request->title );
//        }else
//        {
//            $slug = SlugService::createSlug(Category::class, 'slug', $request->slug);
//        }
//        $request->merge(['slug'=> $slug]);
//
//
//        $category->title = $request->input('title');
//        $category->meta_description = $request->input('meta_description');
//        $category->meta_keywords = $request->input('meta_keywords');
//        $category->category_id = $request->input('category_id');
        try{
            $category->update($request->all());
        }catch (Exception $exception){
            return redirect(route('back.categories.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'دسته بندي با موفقيت ويرايش شد :)' ;
        return redirect(route('back.categories'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (Gate::allows('isAdmin')){
            try{
                $category->delete();
            }catch (Exception $exception){
                return redirect(route('back.categories'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.categories'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }

    }
}
