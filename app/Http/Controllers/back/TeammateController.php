<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\Mail\TeamConfirm;
use App\Mail\TeamSentFinal;
use App\Models\Admin;
use App\Models\Catwork;
use App\Models\Group;
use App\Models\Pack;
use App\Models\Post;
use App\Models\Protranslate;
use App\Models\User;
use App\Models\Work;
use App\Models\Teammate;
use App\Http\Controllers\Controller;
use App\Models\Catorder;
use App\Models\Photo;
use DateTime;
use Exception;
use Ghasedak\GhasedakApi;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TeammateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $teammates = Teammate::orderBy('id','DESC')->paginate(20);
        //dd($teammates);
        return view('back.teammates.teammates',compact('teammates','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $catworks =Catwork::all()->pluck('title','id');
        $catorders =Catorder::all()->pluck('title','id');
        $groups =Group::all()->pluck('title','id');
        $users = User::all()->pluck('lastname','id');
        //dd($users);
        return view('back.teammates.create',compact('user','catworks','catorders','groups','users'));
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
            'major.required' => ' لطفا رشته تحصیلی خود را وارد نمایید',
            'catwork_id.required' => 'لطفا دسته بندی نوع همکاری را  تعيين كنيد ',

        ];
        $validateData = $request->validate([
            'major' => 'required',
            'catwork_id' => 'required',
        ],$messages);


        $teammate = new Teammate();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $teammate->photo_id = $photo->id;
        }


        $teammate->major = $request->input('major');
        $teammate->borndate = $request->input('borndate');
//        $teammate->borndate = new Verta($request->input('borndate'));
        //dd($teammate->borndate);
        $teammate->residence = $request->input('residence');
        $teammate->resume = $request->input('resume');
        $teammate->education = $request->input('education');
        $teammate->description = $request->input('description');
        $teammate->catwork_id = $request->input('catwork_id');
        $teammate->user_id = $request->input('user_id');

        $teammate->fathername = null;
        $teammate->codemeli = null;
        $teammate->maritalstatus = null;
        $teammate->skill = null;
        $teammate->lasteducation = null;
        $teammate->mobile = null;
        $teammate->phone = null;
        $teammate->termcheck = null;
        $teammate->address = null;
        $teammate->catorder_id = null;
        $teammate->status = 3 ;
       //dd($teammate);



        try{
            $teammate->save();
        }catch (Exception $exception){
            return redirect(route('back.teammates.create'))->with('warning',$exception->getCode());
        }
        $msg = 'همکار جدید با موفقیت ایجاد شد.' ;
        return redirect(route('back.teammates'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Teammate $teammate)
    {
        if (Gate::allows('isAdmin')){

            return view('back.teammates.show',compact('teammate'));
        }
        else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }

    }

    public function teammateprint(Teammate $teammate)
    {
        $user = Auth::user();
        $catwork = Catwork::all()->pluck('title','id');
        $catorders =Catorder::all()->pluck('title','id');
        $groups =Group::all()->pluck('title','id')->first();
        return view('back.teammates.teammateprint',compact('user','catwork','teammate','catorders','groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Teammate $teammate)
    {
        if (Gate::allows('isAdmin')){
            $user = Auth::user();
            $catworks = Catwork::all()->pluck('title','id');
            $catorders =Catorder::all()->pluck('title','id');
            $groups =Group::all()->pluck('title','id');
            $packs = Pack::all()->pluck('title','id');
            //dd($teammate);
           return view('back.teammates.edit',compact('teammate','user','catworks','catorders','groups','packs'));
        }
        else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد.' ;
            return back()->with('info',$msg);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teammate $teammate)
    {
        $messages = [
            'status.required' => ' لطفا وضعیت کاربر را وارد نمایید.',
            'lasteducation.required' => 'لطفا آخرین مدرک تحصیلی کاربر را انتخاب کنید. ',

        ];
        $validateData = $request->validate([
            'status' => 'required',
            'lasteducation' => 'required',
        ],$messages);

        $user = User::where('id',$teammate->user_id)->first();
        $develope = Admin::first();
        $teammates =  Teammate::where('user_id',$user->id)->first();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $teammate->photo_id = $photo->id;
        }


//        $teammate->update([
//            'status' => $request->input('status'),
//            'fathername' => $request->input('fathername'),
//            'mobile' => $request->input('mobile'),
//            'phone' => $request->input('phone'),
//            'codemeli' => $request->input('codemeli'),
//            'residence' => $request->input('residence'),
//            'address' => $request->input('address'),
//            'resume' => $request->input('resume'),
//            'education' => $request->input('education'),
//            'maritalstatus' => $request->input('maritalstatus'),
//            'lasteducation' => $request->input('lasteducation'),
//            'catwork_id' => $request->input('catwork_id'),
//            'catorder_id' => $request->input('catorder_id'),
//            'skill' => $request->input('skill'),
//            'description' => $request->input('description'),
//            'user_id' => $user->id,
//            'validate' => 1,
//        ]);
        $teammate->status = $request->input('status');
        $teammate->fathername = $request->input('fathername');
        $teammate->mobile = $request->input('mobile');
        $teammate->phone = $request->input('phone');
        $teammate->codemeli = $request->input('codemeli');
        $teammate->residence = $request->input('residence');
        $teammate->address = $request->input('address');
        $teammate->resume = $request->input('resume');
        $teammate->education = $request->input('education');
        $teammate->maritalstatus = $request->input('maritalstatus');
        $teammate->lasteducation = $request->input('lasteducation');
        $teammate->catwork_id = $request->input('catwork_id');
        $teammate->skill = $request->input('skill');
        $teammate->description = $request->input('description');
        $teammate->user_id = $user->id;


        $roles = $user->roles()->pluck('id')->all();
        $roles = 6 ;
        $user->roles()->attach($roles);


            $site = 'yabane.ir/dashboard/teammates/';


        try{
            $teammate->groups()->sync($request->groups);
            $teammate->packs()->sync($request->packs);
            if ($teammate->status == 3) {
                if ($teammate->validate == null){
                    Mail::to([$develope->email, $user->email])
                        ->send(new TeamConfirm($request, $user));

                    if ($user->mobile) {
                        $receptor = $user->mobile;
                        $type = 1;
                        $template = "teammateConfirm";
                        $param1 = $user->name;
                        $param2 = $site;
                        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                        $api->Verify($receptor, $type, $template, $param1, $param2);
                    }
                }
            }
            $teammate->validate =1;
            $teammate->update();
        }catch (Exception $exception){
            return redirect(route('back.teammates.edit',$teammate->id))->with('warning',$exception->getCode());
        }
        catch (\Ghasedak\Exceptions\ApiException $e) {
             echo $e->errorMessage();
        } catch (\Ghasedak\Exceptions\HttpException $e) {
             echo $e->errorMessage();
        }

        $msg = 'متشکرم ! رزومه کاربر ویرایش شد.' ;
        return redirect(route('back.teammates'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teammate $teammate)
    {
        if (Gate::allows('isAdmin')){
            try{
                $teammate->delete();
            }catch (Exception $exception){
                return redirect(route('back.teammates'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.teammates'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }

    public function updatestatus(Teammate $teammate)
    {
        if (Gate::allows('isAdmin')){
            if ($teammate->status==1)
            {
                $teammate->status = 0;
            }else
            {
                $teammate->status = 1;
            }
            $teammate->save();
            $msg = "بروزرسانی با موفقیت انجام شد ";
            return redirect(route('back.teammates'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند وضعیت مطلبی را تغییر دهد' ;
            return back()->with('info',$msg);
        }

    }

    public function TeamJob()
    {
        $teammates = Teammate::orderBy('id','DESC')->paginate(20);
        //$user = $teammates->user_id;

       // $protranslates = Protranslate::orderBy('id','DESC')->paginate(20);
        $protranslatescount = Protranslate::count();
        //dd($protranslates);
        return view('back.teamjobs.teamjobs',compact('teammates'));
    }

    public function TeamJobshow(Teammate $teammate)
    {
        $user = User::where('id',$teammate->user_id)->first();
        $protranslate = Protranslate::where('user_id',$user->id)->paginate(20);


        $datefirst = Protranslate::pluck('created_at')->first();
        $date1 = new DateTime("now");
        $carbon = Carbon::parse($date1)->diffInDays($datefirst);

        //dd($carbon);

        return view('back.teamjobs.show',compact('teammate','user','protranslate','carbon'));
    }

    public function teamJobsPrint(Teammate $teammate)
    {
        $user = User::where('id',$teammate->user_id)->first();
        $protranslate = Protranslate::where('user_id',$user->id)->paginate(20);

        return view('back.teamjobs.teamjobsprint',compact('teammate','user','protranslate'));
    }
}
