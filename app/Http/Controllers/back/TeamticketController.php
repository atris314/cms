<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Mail\ReplyTicket;
use App\Models\Teamticket;
use App\Models\Ticketreply;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TeamticketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $user = Auth::user();
            $teamtickets = Teamticket::orderBy('id','DESC')->paginate(20);
            return view('back.teamtickets.teamtickets',compact('user','teamtickets'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function reply(Request $request, Teamticket $teamticket)
    {
        $messages = [
            'message.required' => ' لطفا متن پاسخ را وارد نمایید',
        ];
        $validateData = $request->validate([
            'message' => 'required',
        ],$messages);
        $user = Auth::user();
        $code = rand(10000, 20000);
        $teamtickets = Teamticket::where('id',$teamticket->id)->first();

        $ticketreplies = new Ticketreply();
        $ticketreplies->title = $teamtickets->title;
        $ticketreplies->user_id = Auth::user()->id;
        $ticketreplies->ticket_id = $teamtickets->ticket_id;
        $ticketreplies->catorder_id = $teamtickets->catorder_id;
        $ticketreplies->priority = $teamtickets->priority;
        $ticketreplies->message = $request->message;
        $ticketreplies->status = 1;
        $ticketreplies->parent_id = $teamtickets->id;
        $teamticket->status = 2 ;
        $teamticket->save();
        //dd($ticketreplies);


        $users = User::where('id',$teamticket->user_id)->first();
        $user = Auth::user();

        Mail::to([$users->email , $user->email])
            ->send(new ReplyTicket($request,$users,$teamticket,$user));



        try{
            $ticketreplies->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'تیکت شما پاسخ داده شد' ;
        return redirect(route('back.teamtickets.show',$teamtickets->id))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teamticket  $teamticket
     * @return \Illuminate\Http\Response
     */
    public function show(Teamticket $teamticket)
    {
        $user = Auth::user();
        $ticketreplies = Ticketreply::where('parent_id',$teamticket->id)->get();
        //dd($ticketreplies);
        return view('back.teamtickets.show',compact('teamticket','ticketreplies','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teamticket  $teamticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Teamticket $teamticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teamticket  $teamticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teamticket $teamticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teamticket  $teamticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teamticket $teamticket)
    {
        if (Gate::allows('isAdmin')){
            try{
                $teamticket->delete();
            }catch (Exception $exception){
                return redirect(route('back.teamtickets'))->with('warning',$exception->getCode());
            }
            $msg = 'تیکت مورد نظر حذف گردید :)' ;
            return redirect(route('back.teamtickets'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }

    public function updatestatus(Teamticket $teamticket)
    {
        if ($teamticket->status==1)
        {
            $teamticket->status = 0;
        }else
        {
            $teamticket->status = 1;
        }
        $teamticket->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.teamtickets'))->with('success',$msg);

    }
}
