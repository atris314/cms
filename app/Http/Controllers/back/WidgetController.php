<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Photo;
use App\Models\Widget;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $widgets = Widget::orderBY('created_at','DESC')->paginate(20);
        return view('back.widgets.widgets',compact('widgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.widgets.create');
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


        $widget = new Widget();

        $widget->title = $request->input('title');
        $widget->description = $request->input('description');

        try{
            $widget->save();
        }catch (Exception $exception){
            return redirect(route('back.widgets.create'))->with('warning',$exception->getCode());
        }
        $msg = ' با موفقیت ایجاد شد :)' ;
        return redirect(route('back.widgets'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function show(widget $widget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function edit(widget $widget)
    {
        return view('back.widgets.edit',compact('widget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, widget $widget)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ],$messages);

        $widget->title = $request->input('title');
        $widget->description = $request->input('description');

        try{
            $widget->update();
        }catch (Exception $exception){
            return redirect(route('back.widgets.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'ویرایش انجام شد' ;
        return redirect(route('back.widgets'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function destroy(widget $widget)
    {
        if (Gate::allows('isAdmin')){
            try{
                $widget->delete();
            }catch (Exception $exception){
                return redirect(route('back.widgets'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.widgets'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
