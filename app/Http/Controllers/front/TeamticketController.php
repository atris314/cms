<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Catorder;
use App\frontmodels\Protranslate;
use App\frontmodels\Teammate;
use App\frontmodels\Ticket;
use App\frontmodels\Ticketreply;
use App\Http\Controllers\Controller;
use App\frontmodels\Teamticket;
use App\Mail\ReplyTicket;
use App\Mail\TicketSent;
use App\Models\User;
use App\Notifications\TeamRequest;
use App\Notifications\TicketTeamAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class TeamticketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $user = Auth::user();
            $teamtickets = Teamticket::orderBy('id','DESC')->paginate(20);
            $protranslatescount = Protranslate::count();
            $team = Teammate::where('user_id',Auth::id())->first();
            return view('front.teamtickets.teamtickets',compact('user','teamtickets','protranslatescount','team'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $catorders = Catorder::orderby('id','desc')->get()->pluck('title','id');
        $teammates = Teammate::with('user')->where('user_id',$user->id)->first();
        $teammate = $teammates->groups()->pluck('catorder_id')->first();
        $protranslatescount = Protranslate::count();
        $team = Teammate::where('user_id',Auth::id())->first();
        //dd($teammate);
        return view('front.workboard.ticket',compact('catorders','user','teammate','protranslatescount','team'));
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
            'title.required' => ' لطفا نام را وارد نمایید',
            'email.required' => ' لطفا ایمیل را وارد نمایید',
            'message.required' => ' لطفا متن تیکت خود را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'message' => 'required',
        ],$messages);

        $code = rand(10000, 20000);

        $teamticket = new Teamticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => $code,
            'catorder_id'  => $request->input('catorder_id'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "1",
        ]);
        //dd($teamticket);

        $users = Auth::user();
        //dd($users);

        Mail::to($users->email)
            ->send(new TicketSent($request,$users,$code));

        $users = \App\Models\User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get();
        Notification::send($users , new TicketTeamAdd($teamticket->title));

        try{
            $teamticket->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! تیکت شما با موفقیت ایجاد شد' ;
        return redirect(route('teammate-ticketshow.all'))->with('success',$msg);
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
        $catorder = Catorder::all();
        $ticketreplies = Ticketreply::where('parent_id',$teamticket->id)->get();
        $protranslatescount = Protranslate::count();
        $team = Teammate::where('user_id',Auth::id())->first();
        //dd($ticketreplies);
        return view('front.workboard.ticketdetail',compact('teamticket','user','catorder','ticketreplies','protranslatescount','team'));
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
        //
    }

    public function teammateTicketshow()
    {
        $user = Auth::user();
        $catorders = Catorder::all()->pluck('title','id');
        $ticketset = Teamticket::with('user')->where('user_id',$user->id)->first();
        $teamtickets = Teamticket::with('user')->where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(20);
        $protranslatescount = Protranslate::count();
        $team = Teammate::where('user_id',Auth::id())->first();
        //dd($teamtickets);
        return view('front.workboard.ticketshow',compact('user','catorders','teamtickets','ticketset','protranslatescount','team'));
    }


    public function reply(Request $request,Teamticket $teamticket)
    {
        $messages = [
            'message.required' => ' لطفا متن پاسخ را وارد نمایید',
        ];
        $validateData = $request->validate([
            'message' => 'required',
        ],$messages);

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



        if ( $ticketreplie = Ticketreply::where('parent_id',$teamtickets->id)->first()) {
            $users = User::where('id', $ticketreplie->user_id)->first();
        }
        else{
            $users = Auth::user();
        }
        $user = Auth::user();


        Mail::to([$users->email , $user->email])
            ->send(new ReplyTicket($request,$users,$teamticket,$user));



        try{
            $ticketreplies->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'تیکت شما پاسخ داده شد' ;
        return redirect(route('teammate-ticket.show',$teamtickets->id))->with('success',$msg);
    }
}
