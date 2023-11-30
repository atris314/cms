<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Contact;
use App\frontmodels\Coupon;
use App\frontmodels\Product;
use App\frontmodels\Teammate;
use App\frontmodels\Teamticket;
use App\frontmodels\Ticketreply;
use App\Http\Controllers\Controller;
use App\frontmodels\Category;
use App\frontmodels\Catorder;
use App\frontmodels\Ticket;
use App\Mail\ContactSent;
use App\Mail\ReplyTicket;
use App\Mail\TicketSent;
use App\Models\Confirmation;
use App\Models\Pack;
use App\Models\User;
use App\Notifications\TeamRequest;
use App\Notifications\TicketUserAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::orderBy('id','DESC')->paginate(20);
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('back.tickets.tickets',compact('tickets','user','productcount'));
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
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.ticket',compact('catorders','user','productcount'));
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
            'priority.required' => ' لطفا اولویت را تعیین کنید',
            'message.required' => ' لطفا متن تیکت خود را وارد نمایید',

        ];
        $validateData = $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'message' => 'required',
        ],$messages);

        $code = rand(10000, 20000);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => $code,
            'catorder_id'  => $request->input('catorder_id'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => 1,
        ]);
        //dd($ticket);



        $users = Auth::user();
        //dd($users);

        Mail::to($users->email)
            ->send(new TicketSent($request,$users,$code));

        $users = \App\Models\User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get();
        Notification::send($users , new TicketUserAdd($ticket->title));

        try{
            $ticket->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'تیکت شما ایجاد شد . پشتیبان مربوطه در کمترین زمان پاسخ شما را خواهد داد.' ;
        return redirect(route('ticketshow'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */



    public function ticketshow()
    {
        $user = Auth::user();
        $catorders = Catorder::all()->pluck('title','id');
        $ticketset = Ticket::with('user')->where('user_id',$user->id)->first();
        $tickets = Ticket::with('user')->where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(20);
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();

        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->get();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();
        return view('front.dashboard.ticketshow',compact('user','catorders','tickets','ticketset','productcount','confirmationset'));
    }

    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        $catorder = Catorder::all();
        $ticketreplies = Ticketreply::where('parent_id',$ticket->id)->get();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.ticketdetail',compact('ticket','user','catorder','ticketreplies','productcount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        if (Gate::allows('isAdmin')) {
            return view('back.tickets.edit', compact('ticket'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد';
            return back()->with('info',$msg);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function reply(Request $request,Ticket $ticket)
    {
        $messages = [
            'message.required' => ' لطفا متن پاسخ را وارد نمایید',
        ];
        $validateData = $request->validate([
            'message' => 'required',
        ],$messages);

        $code = rand(10000, 20000);
        $tickets = Ticket::where('id',$ticket->id)->first();
        $ticketreplies = new Ticketreply();
        $ticketreplies->title = $tickets->title;
        $ticketreplies->user_id = Auth::user()->id;
        $ticketreplies->ticket_id = $tickets->ticket_id;
        $ticketreplies->catorder_id = $tickets->catorder_id;
        $ticketreplies->priority = $tickets->priority;
        $ticketreplies->message = $request->message;
        $ticketreplies->status = 1;
        $ticketreplies->parent_id = $tickets->id;
        $tickets->status = 2 ;
        $tickets->save();




        if( $ticketreplie = Ticketreply::where('parent_id',$ticket->id)->first())
        {
            $users = User::where('id',$ticketreplie->user_id)->first();
        }
        else
        {
            $users = Auth::user();
        }
        $user = Auth::user();

        Mail::to([$users->email , $user->email])
            ->send(new ReplyTicket($request,$users,$tickets,$user));


        try{
            $ticketreplies->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'تیکت شما پاسخ داده شد' ;
        return redirect(route('ticket.show',$ticket->id))->with('success',$msg);
    }


}
