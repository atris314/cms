<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderby('created_at','desc')->paginate(20);
        return view('back.customers.customers',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.customers.create');
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
            'photo_id.required' => ' لطفا تصویر را وارد نماييد',

        ];
        $validateData = $request->validate([
            'name' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $customer = new Customer();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $customer->photo_id = $photo->id;
        }


        $customer->name = $request->input('name');
        $customer->job = $request->input('job');
        $customer->comment = $request->input('comment');


        try{
            $customer->save();
        }catch (Exception $exception){
            return redirect(route('back.customers.create'))->with('warning',$exception->getCode());
        }
        $msg = ' با موفقیت ایجاد شد :)' ;
        return redirect(route('back.customers'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('back.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $customer->photo_id = $photo->id;
        }
        $customer->name = $request->input('name');
        $customer->job = $request->input('job');
        $customer->comment = $request->input('comment');
        try{
            $customer->save();
        }catch (Exception $exception){
            return redirect(route('back.customers.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' ویرایش انجام شد :)' ;
        return redirect(route('back.customers'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try{
            $customer->delete();
        }catch (Exception $exception){
            return redirect(route('back.customers'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.customers'))->with('success',$msg);
    }
}
