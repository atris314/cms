<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Mail\ReplyTicket;
use App\Mail\TicketSent;
use App\Models\Category;
use App\Models\Catorder;
use App\Models\Ticket;
use App\Models\Ticketreply;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $tickets = Ticket::with('user')->orderBy('id','DESC')->paginate(20);
        //dd($tickets);
        return view('back.tickets.tickets',compact('tickets','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('isAdmin')){
            $catorders = Catorder::all()->pluck('title','id');
            return view('back.tickets.create',compact('catorders'));
        }else{
            $msg = 'فقط مدیر اجازه حذف دارد' ;
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        $ticketreplies = Ticketreply::where('parent_id',$ticket->id)->get();
        //dd($ticketreplies);
        return view('back.tickets.show',compact('ticket','ticketreplies','user'));
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
        if (Gate::allows('isAdmin')){
            try{
                $ticket->delete();
            }catch (Exception $exception){
                return redirect(route('back.tickets'))->with('warning',$exception->getCode());
            }
            $msg = 'تیکت مورد نظر حذف گردید :)' ;
            return redirect(route('back.tickets'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
    public function replydestroy(Ticketreply $ticketreply)
    {

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
        // dd($tickets);

        $users = User::where('id',$tickets->user_id)->first();
        $user = Auth::user();

        Mail::to([$users->email , $user->email])
            ->send(new ReplyTicket($request,$users,$tickets,$user));


        try{
            $ticketreplies->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'تیکت شما پاسخ داده شد' ;
        return redirect(route('back.tickets.show',$ticket->id))->with('success',$msg);
    }




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////  resource controller for isSupport/////////////////////////////////////////
    public function supportTicketIndex()
    {
        $user = Auth::user();
        $tickets = Ticket::with('user')->orderBy('id','DESC')->paginate(20);
        //dd($tickets);
        return view('back.tickets.tickets',compact('tickets','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function supportTicketCreate()
    {
        if (Gate::allows('isAdmin')){
            $catorders = Catorder::all()->pluck('title','id');
            return view('back.tickets.create',compact('catorders'));
        }else{
            $msg = 'فقط مدیر اجازه حذف دارد' ;
            return back()->with('info',$msg);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function supportTicketStore(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function supportTicketShow(Ticket $ticket)
    {
        $user = Auth::user();
        $ticketreplies = Ticketreply::where('parent_id',$ticket->id)->get();
        //dd($ticketreplies);
        return view('back.tickets.show',compact('ticket','ticketreplies','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function supportTicketEdit(Ticket $ticket)
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
    public function supportTicketUpdate(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function supportTicketDestroy(Ticket $ticket)
    {
        if (Gate::allows('isAdmin')){
            try{
                $ticket->delete();
            }catch (Exception $exception){
                return redirect(route('back.tickets'))->with('warning',$exception->getCode());
            }
            $msg = 'تیکت مورد نظر حذف گردید :)' ;
            return redirect(route('back.tickets'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }


    public function supportTicketUpdatestatus(Request $request,Ticket $ticket)
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
        // dd($tickets);
        try{
            $ticketreplies->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'تیکت شما پاسخ داده شد' ;
        return redirect(route('back.tickets.show',$ticket->id))->with('success',$msg);
    }

}
