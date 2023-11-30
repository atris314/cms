<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $clients = Client::orderBy('id' , 'DESC')->paginate(10);
            return view('back.clients.clients',compact('clients'));
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
            return view('back.clients.create');
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
            'name.required' => ' لطفا فیلد نام را وارد نمایید',

        ];
        $validateData = $request->validate([
            'name' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $client = new Client();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $client->photo_id = $photo->id;
        }
        $client->name = $request->input('name');
        try{
            $client->save();
        }catch (Exeption $exception){
            return redirect(route('back.clients.create'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مشتری جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.clients'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if (Gate::allows('isAdmin')){
            return view('back.clients.edit',compact('client'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $messages = [
            'name.required' => ' لطفا فیلد نام را وارد نمایید',

        ];
        $validateData = $request->validate([
            'name' => 'required',
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
            $client->photo_id = $photo->id;
        }
        $client->name = $request->input('name');
        try{
            $client->update();
        }catch (Exception $exception){
            return redirect(route('back.clients.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مشتری جدید با موفقیت ویرایش شد :)' ;
        return redirect(route('back.clients'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if (Gate::allows('isAdmin')){
            try{
                $client->delete();
            }catch (Exception $exception){
                return redirect(route('back.clients'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.clients'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }

    }
}
