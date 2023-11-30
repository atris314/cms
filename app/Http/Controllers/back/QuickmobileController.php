<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Quickmobile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuickmobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quickmobiles = Quickmobile::orderby('created_at','desc')->paginate(30);
        return view('back.quickmobiles.quickmobiles',compact('quickmobiles'));
    }


    public function destroy(Quickmobile $quickmobile)
    {
        if (Gate::allows('isAdmin')){
            try{
                $quickmobile->delete();
            }catch (Exception $exception){
                return redirect(route('back.quickmobiles'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.quickmobiles'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
