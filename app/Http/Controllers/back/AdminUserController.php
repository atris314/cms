<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Photo;
use App\Models\Province;
use App\Models\Role;
use App\Models\Teammate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('salam');
        if (Gate::allows('isAdmin')){
            //        $users = User::with('roles')->get();
            $roles = Role::all()->pluck('name','id');
            $users = User::Orderby('rate','ASC')->paginate(30);
            //dd($users);
            return view('back.users.users',compact('users','roles'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
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
        $proviencs = Province::all()->pluck('name','id');
        $cities = City::all()->pluck('name','id');
        $roles = Role::all()->pluck('name','id');
        if(Gate::allows('isAdmin',$roles)){
            return view('back.users.create',compact('roles','proviencs','cities'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
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
//        dd($request);
        $messages = [
            'name.required' => 'فیلد نام را وارد نمایید',
            'email.required' => 'فیلد ایمیل را وارد نمایید',
            'email.email' => 'ايميل وارد شده معتبر نيست',
            'email.unique' => 'ايميل وارد شده تكراري است',
            'password.required' => 'فيلد رمز عبور را وارد نماييد',
            'password.min' => 'رمز عبور بايد بيشتر از 6 كاراكتر باشد',
            'status.required' => 'فيلد وضعيت را وارد نماييد',
            'roles.required' => 'نقش كاربر را  تعيين كنيد',
        ];
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'status' => 'required',
            'roles' => 'required',
        ],$messages);

        $user = new User();
        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $user->photo_id = $photo->id;
        }
        $subste = explode("@", $request->input('email'));
        $item = $subste[0];
        $username = $item.rand(100 , 2000);
        $code = '#IRCH'.rand(1000,90000);
        $random = rand(1000 , 2000);

        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->username = $username;
        $user->code = $code;
        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->mobile = $request->input('mobile');
        $user->phone = $request->input('phone');
        $user->jobs = $request->input('jobs');
        $user->companyname = $request->input('companyname');
        $user->postcode = $request->input('postcode');
        $user->province_id = $request->input('province_id');
        $user->city_id = $request->input('city_id');
        $user->address = $request->input('address');
        $user->password = bcrypt($request->input('password'));

        try{
            $user->save();
            $user->roles()->attach($request->roles);
        }catch (Exception $exception){
            return redirect(route('back.users.create'))->with('warning',$exception->getCode());
        }
        $msg = 'ذخيره كاربر جديد با موفقیت انجام شد :)' ;
        return redirect(route('back.users'))->with('success',$msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $notifications = auth()->user()->notifications;
        $notifications ->markAsread();
        //dd($notifications);
        return view('back.notifications',compact('notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all()->pluck('name','id');
        return view('back.users.edit',compact('user','roles'));
//        if (Gate::allows('isAdmin')){
//
//        }else{
//            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
//            return back()->with('info',$msg);
//        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
//        $user = User::findOrFail($user);
        $messages = [
            'email.required' => 'فیلد ایمیل را وارد نمایید',
            'status.required' => 'فيلد وضعيت را وارد نماييد',
            'password.min' => 'رمز عبور بايد بيشتر از 6 كاراكتر باشد',
        ];
        $validateData = $request->validate([
            'email' => 'required',
            'status' => 'required',
            'password' => 'nullable|min:6',
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
            $user->photo_id = $photo->id;
        }
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->phone = $request->input('phone');
        $user->mobile = $request->input('mobile');
        $user->phone = $request->input('phone');
        $user->jobs = $request->input('jobs');
        $user->companyname = $request->input('companyname');
        $user->postcode = $request->input('postcode');
        $user->address = $request->input('address');
        $user->rate = $request->input('rate');
        $user->enaddress = $request->input('enaddress');


//        if (trim($request->input('password') != "")){
//            $user->password = bcrypt($request->input('password'));
//        }
        if ($request->input('password')){
            $user->password = bcrypt($request->input('password'));
        }
        //dd($user);
        try{
            $user->update();
            $user->roles()->sync($request->roles);
        }catch (Exception $exception){
            return redirect(route('back.users.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'ذخيره كاربر جديد با موفقیت انجام شد :)' ;
        return redirect(route('back.users'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( User $user)
    {
        if (Gate::allows('isAdmin')){
            if ($user->photo_id){
                $photo = Photo::findOrFail($user->photo_id);
                unlink(public_path(). $user->photo->path);
                $photo->delete();
            }
            $user -> delete();
            $msg = "كاربر مورد نظر حذف شد";
            return redirect(route('back.users'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می  تواند کاربری را حذف کند.' ;
            return route('back.users')->with('info',$msg);
        }
    }

    public function updatestatus(User $user)
    {
        if (Gate::allows('isAdmin')){
            if ($user->status==1)
            {
                $user->status = 0;
            }else
            {
                $user->status = 1;
            }
            $user->save();
            $msg = "بروزرسانی با موفقیت انجام شد :)";
            return redirect(route('back.users'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می  تواند وضعیت کاربر را تغییر دهد.' ;
            return back()->with('info',$msg);
        }

    }
    public function profile(User $user)
    {
        $teammate = Teammate::where('user_id',$user->id)->first();
        //dd($teammate);
        return view('back.users.profile',compact('user','teammate'));
    }

    public function userSearch(Request $request)
    {
        $query = $request->input('roles');

        $users = User::whereHas('roles' , function($q) use ($query) {
            $q->where('role_id', 'like' , '%'.$query.'%');
        })->paginate(20);


        $roles = Role::all()->pluck('name','id');
        return view('back.users.search',compact('users','query','roles'));
    }
    public function userCodeSearch(Request $request)
    {
        $query = $request->input('code');

        $users = User::where('code',$query)->get();
        $roles = Role::all()->pluck('name','id');
        return view('back.users.codesearch',compact('users','query','roles'));
    }
    public function mobileSearch(Request $request)
    {
        $query = $request->input('mobile');

        $users = User::where('mobile',$query)->paginate(5);
        $roles = Role::all()->pluck('name','id');
        return view('back.users.users',compact('users','query','roles'));
    }

}
