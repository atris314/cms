<?php

namespace App\Http\Controllers\back;


use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Exception;


class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $portfolios = Portfolio::orderBy('id','DESC')->paginate(10);
            $photo = Photo::first();

            return view('back.portfolios.portfolios',compact('portfolios'));
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
            return view('back.portfolios.create');
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
        //
        $messages = [
            'name.required' => ' لطفا فیلد نام را وارد نمایید',
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',

        ];
        $validateData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ],$messages);


        $portfolio = new Portfolio();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $portfolio->photo_id = $photo->id;
        }

        $photos = explode(',', $request->input('photos')[0]);

        $portfolio->name = $request->input('name');
        $portfolio->tag = $request->input('tag');
        $portfolio->link = $request->input('link');
        $portfolio->description = $request->input('description');
        $portfolio->title = $request->input('title');
        $portfolio->body = $request->input('body');
        //dd($photos);

        try{

            $portfolio->save();
            $portfolio->photos()->attach($photos);
        }catch (Exception $exception){
            return redirect(route('back.portfolios.create'))->with('warning',$exception->getCode());
        }
        $msg = 'نمونه سفارش جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.portfolios'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        if (Gate::allows('isAdmin')){
            return view('back.portfolios.edit',compact('portfolio'));
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
    public function update(Request $request, Portfolio $portfolio)
    {

        $messages = [
            'photos.required' => 'لطفا تصویر مورد نظر را آپلود کنید',
        ];
        $validateData = $request->validate([
            'photos' => 'required',
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
            $portfolio->photo_id = $photo->id;
        }
        $portfolio->name = $request->input('name');
        $portfolio->tag = $request->input('tag');
        $portfolio->link = $request->input('link');
        $portfolio->description = $request->input('description');
        $portfolio->title = $request->input('title');
        $portfolio->body = $request->input('body');
       // dd($photos);

        try{
            $portfolio->update();
            if (isset($request->input('photos')[0])){
                $photos = explode(',', $request->input('photos')[0]);
                $portfolio->photos()->attach($photos);
            }
        }catch (Exception $exception){
            return redirect(route('back.portfolios.edit',$portfolio->id))->with('warning',$exception->getCode());
        }
        $msg = 'نمونه سفارش  با موفقیت ویرایش شد :)' ;
        return redirect(route('back.portfolios'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        if (Gate::allows('isAdmin'))
        {
            try{
                $portfolio->delete();
            }catch (Exception $exception){
                return redirect(route('back.portfolios'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.portfolios'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }


    }
}
