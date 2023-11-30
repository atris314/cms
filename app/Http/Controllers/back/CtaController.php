<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Cta;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CtaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $ctas = Cta::orderBy('id','DESC')->paginate(5);
            return view('back.ctas.ctas',compact('ctas'));
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
            return view('back.ctas.create');
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
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ],$messages);

        $cta = new Cta();

        $cta->title = $request->input('title');
        $cta->description = $request->input('description');

        try{
            $cta->save();
        }catch (Exception $exception){
            return redirect(route('back.ctas.create'))->with('warning',$exception->getCode());
        }
        $msg = 'اکشن با موفقیت ایجاد شد :)' ;
        return redirect(route('back.ctas'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cta  $cta
     * @return \Illuminate\Http\Response
     */
    public function show(Cta $cta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cta  $cta
     * @return \Illuminate\Http\Response
     */
    public function edit(Cta $cta)
    {
        if (Gate::allows('isAdmin')){
            return view('back.ctas.edit',compact('cta'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cta  $cta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cta $cta)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);


        $cta->title = $request->input('title');
        $cta->description = $request->input('description');

        try{
            $cta->update();
        }catch (Exception $exception){
            return redirect(route('back.ctas.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'اکشن با موفقیت ویرایش شد :)' ;
        return redirect(route('back.ctas'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cta  $cta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cta $cta)
    {
        if(Gate::allows('isAdmin')){
            try{
                $cta->delete();
            }catch (Exception $exception){
                return redirect(route('back.ctas'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.ctas'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }
}
