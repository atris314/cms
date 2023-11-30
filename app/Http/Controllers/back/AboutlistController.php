<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Aboutlist;
use App\Models\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class AboutlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $aboutlists = Aboutlist::orderBy('id','DESC')->paginate(5);
            return view('back.aboutlists.aboutlists',compact('aboutlists'));
        }else{

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.aboutlists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);


        $aboutlists = new Aboutlist();
        $aboutlists->title = $request->input('title');

        try{
            $aboutlists->save();
        }catch (Exception $exception){
            return redirect(route('back.aboutlists.create'))->with('warning',$exception->getCode());
        }
        $msg = 'ویجت ویژگی با موفقیت ایجاد شد :)' ;
        return redirect(route('back.aboutlists'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aboutlist  $aboutlist
     * @return \Illuminate\Http\Response
     */
    public function show(Aboutlist $aboutlist)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aboutlist  $aboutlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Aboutlist $aboutlist)
    {
        return view('back.aboutlists.edit',compact('aboutlist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aboutlist  $aboutlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aboutlist $aboutlist)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);

        $aboutlist->title = $request->input('title');

        try{
            $aboutlist->update();
        }catch (Exception $exception){
            return redirect(route('back.aboutlists.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'ویجت ویژگی با موفقیت ویرایش شد :)' ;
        return redirect(route('back.aboutlists'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aboutlist  $aboutlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aboutlist $aboutlist)
    {
        try{
            $aboutlist->delete();
        }catch (Exception $exception){
            return redirect(route('back.aboutlists'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.aboutlists'))->with('success',$msg);
    }
}
