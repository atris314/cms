<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $services = Service::orderBy('id','DESC')->paginate(10);
            return view('back.services.services',compact('services'));
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
            return view('back.services.create');
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
            'body.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'icon.required' => ' لطفا فیلد کلاس آیکون را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'icon' => 'required',
        ],$messages);

        $services = new Service();

        $services->title = $request->input('title');
        $services->icon = $request->input('icon');
        $services->body = $request->input('body');

        try{
            $services->save();
        }catch (Exception $exception){
            return redirect(route('back.services.create'))->with('warning',$exception->getCode());
        }
        $msg = ' خدمات جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.services'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        if (Gate::allows('isAdmin')){
            return view('back.services.edit',compact('service'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'body.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'icon.required' => ' لطفا فیلد کلاس آیکون را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'icon' => 'required',
        ],$messages);

        $service->title = $request->input('title');
        $service->icon = $request->input('icon');
        $service->body = $request->input('body');

        try{
            $service->save();
        }catch (Exception $exception){
            return redirect(route('back.services.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' خدمات با موفقیت ویرایش شد :)' ;
        return redirect(route('back.services'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if (Gate::allows('isAdmin')){
            try{
                $service->delete();
            }catch (Exception $exception){
                return redirect(route('back.services'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.services'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }

    }
}
