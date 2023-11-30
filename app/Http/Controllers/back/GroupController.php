<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Catorder;
use App\Models\Group;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $groups = Group::with('catorder')->orderBy('id','DESC')->paginate(20);
            return view('back.groups.groups',compact('groups'));
        }else
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
        return back()->with('info',$msg);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('isAdmin'))
        {
            $catorders =Catorder::all()->pluck('title','id');
            return view('back.groups.create',compact('catorders'));
        }else
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
        return back()->with('info',$msg);
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

        $groups = new Group([
            'title'     => $request->input('title'),
            'catorder_id'  => $request->input('catorder_id'),
        ]);
        //dd($groups);
        try{
            $groups->save();
        }catch (Exception $exception){
            return redirect(route('back.groups.create'))->with('warning',$exception->getCode());
        }
        $msg = 'گروه بندي جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.groups'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        if(Gate::allows('isAdmin'))
        {
            $catorders =Catorder::all()->pluck('title','id');
            return view('back.groups.edit',compact('catorders','group'));
        }else
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
        return back()->with('info',$msg);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        $group->title = $request->input('title');
        $group->catorder_id = $request->input('catorder_id');
        try{
            $group->update();
        }catch (Exception $exception){
            return redirect(route('back.groups.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'گروه بندي  با موفقیت ویرایش شد :)' ;
        return redirect(route('back.groups'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if (Gate::allows('isAdmin')){
            try{
                $group->delete();
            }catch (Exception $exception){
                return redirect(route('back.groups'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.groups'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
