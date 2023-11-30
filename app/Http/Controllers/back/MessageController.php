<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\frontmodels\Protranslate;
use App\Http\Controllers\Controller;
use App\Mail\MessageTeamSent;
use App\Mail\TeamSentFinal;
use App\Models\About;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Photo;
use App\Models\Teammate;
use App\Models\User;
use App\Notifications\DescriptionAdd;
use App\Notifications\ProductAdd;
use Exception;
use Ghasedak\GhasedakApi;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::orderBy('created_at','desc')->paginate(30);
        return view('back.messages.messages',compact('messages'));
    }

    public function show(Message $message)
    {
        return view('back.messages.show',compact('message'));
    }
    public function destroy(Message $message)
    {
        if (Gate::allows('isAdmin')){
            try{
                $message->delete();
            }catch (Exception $exception){
                return redirect(route('back.messages'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.messages'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
