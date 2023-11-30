<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Photo;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $menus = Menu::orderBy('id','DESC')->paginate('20');
            return view('back.menus.menus',compact('menus'));
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
        $role = Role::all();
        $menutop = Menu::all()->pluck('title','id');
        if (Gate::allows('isAdmin',$role)){
            return view('back.menus.create',compact('menutop'));
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

        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        $menu = new Menu();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $menu->photo_id = $photo->id;
        }

        $menu->title = $request->input('title');
        $menu->post_id = $request->input('post_id');
        $menu->sort = $request->input('sort');
        $menu->url = $request->input('url');
        $menu->status = $request->input('status');

        try {
            $menu->save();
        } catch (Exception $exception) {
            return redirect(route('back.menus.create'))->with('warning', $exception->getCode());
        }

        $msg = "ذخیره ی منوی جدید با موفقیت انجام شد";
        return redirect(route('back.menus'))->with('success', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $role = Role::all();
        $menusub = Menu::all()->pluck('title','id');
        if (Gate::allows('isAdmin',$role)){
            return view('back.menus.edit',compact('menu','menusub'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
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
            $menu->photo_id = $photo->id;
        }
        $menu->title = $request->input('title');
        $menu->post_id = $request->input('post_id');
        $menu->sort = $request->input('sort');
        $menu->url = $request->input('url');
        $menu->status = $request->input('status');
        try {
            $menu->update();
        } catch (Exception $exception) {
            return redirect(route('back.menus.edit'))->with('warning', $exception->getCode());
        }

        $msg = "منو با موفقیت ویرایش شد";
        return redirect(route('back.menus'))->with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $role = Role::all();
        if (Gate::allows('isAdmin',$role)){
            try{
                $menu->delete();
            }catch (Exception $exception){
                return redirect(route('back.menus'))->with('warning',$exception->getCode());
            }
            $msg = 'منو مورد نظر حذف گردید :)' ;
            return redirect(route('back.menus'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }
    }
    public function updatestatus(Menu $menu)
    {
        $role = Role::all();
        if (Gate::allows('isAdmin',$role)){
            if ($menu->status==1)
            {
                $menu->status = 0;
            }else
            {
                $menu->status = 1;
            }
            $menu->save();
            $msg = "بروزرسانی با موفقیت انجام شد :)";
            return redirect(route('back.menus'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند تغییرات اعمال کند' ;
            return back()->with('info',$msg);
        }

    }
}
