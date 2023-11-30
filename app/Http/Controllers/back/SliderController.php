<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Exception;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id','DESC')->paginate('5');
        return view('back.sliders.sliders',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $messages = [
            'title.required' => 'فیلد عنوان را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        $slider = new Slider();
        try{
            $slider->create($request->all());
        }catch (Exception $exception){
            return redirect(route('back.sliders.create'))->with('warning',$exception->getCode());
        }

        $msg = ' اسلایدر با موفقیت ایجاد شد :)' ;
        return redirect(route('back.sliders'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('back.sliders.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $messages = [
            'title.required' => 'فیلد عنوان را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        try{
            $slider->update($request->all());
        }catch (Exception $exception){
            return redirect(route('back.sliders.create'))->with('warning',$exception->getCode());
        }

        $msg = ' اسلایدر با موفقیت ویرایش شد :)' ;
        return redirect(route('back.sliders'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        try{
            $slider->delete();
        }catch (Exception $exception){
            return redirect(route('back.sliders'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.sliders'))->with('success',$msg);
    }
}
