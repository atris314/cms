<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Product;
use App\frontmodels\Protranslate;
use App\Http\Controllers\Controller;
use App\Mail\MessageTeamSent;
use App\Mail\TeamSentFinal;
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
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{

    public function store(Request $request,Product $product)
    {
        $products = Product::where('id', $product->id)->first();
        $user = User::where('id',$products->user_id)->first();
        $develope = Admin::first();
        $messages = [
            'message.required' => 'پیغام خود را بنویسید',
        ];
        $validateData = $request->validate([
            'message' => 'required',
        ],$messages);

        $message = new Message();
        $message->message = $request->input('message');
        $message->product_id = $products->id;
        $message->user_id = Auth::user()->id;

        $product = Product::where('id',$message->product_id)->first();
        $product->status = 12;
        $product->update();


        //dd($product);

            Mail::to(['yabane.managment.@gmail.com',$user->email])
                ->send(new MessageTeamSent($request,$user,$products,$product,$message));

        $users = \App\Models\User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get();
            Notification::send($users , new DescriptionAdd($product));

        $site = route('product.edit',$product);
        //dd($user);
//        if ($user->mobile){
//            try{
//                $receptor = $user->mobile;
//                $type = 1;
//                $template = "DescriptionAdd";
//                $param1 = $user->name;
//                $param2 = $product->codepro;
//                $param3 = $message->message;
//                $param4 = $site;
//                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                $api->Verify($receptor, $type, $template, $param1,$param2,$param3,$param4);
//            }
//            catch(\Ghasedak\Exceptions\ApiException $e){
//                echo $e->errorMessage();
//            }
//            catch(\Ghasedak\Exceptions\HttpException $e){
//                echo $e->errorMessage();
//            }
//        }
        try{
            $message->save();
            if ($user->mobile){
                $receptor = $user->mobile;
                $type = 1;
                $template = "DescriptionAdd";
                $param1 = $user->lastname;
                $param2 = $product->codepro;
                $param3 = $site;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1,$param2,$param3);
            }
        }catch (Exception $exception){
            return redirect(route('checkingPro',$product->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! پیغام شما برای مشتری ارسال شد تا سفارش خود را ویرایش کند.' ;
        return redirect(route('checkingPro',$product->id))->with('success',$msg);
    }


    public function productMessage()
    {
        $user = Auth::user();
        $messages = Message::where('user_id',$user->id)->pluck('product_id')->all();
        $teammates = \App\frontmodels\Teammate::with('user')->where('user_id', $user->id)->first();
        if ($teammates) {
            $teammate = $teammates->groups()->pluck('catorder_id')->all();
            $packs = $teammates->packs()->pluck('pack_id')->all();
        $products = Product::
        whereIn('catorder_id', $teammate)
            ->whereIn('pack_id', $packs)
            ->whereIn('id',$messages)
            ->where('user_id',$user->id)
            ->where('status',12)
            ->where('status','<>',7)
            ->where('status','<>',11)
            ->where('status','<>',10)
            ->where('status','<>',9)
            ->where('status','<>',8)
            ->where('status','<>',5)
            ->where('status','<>',4)
            ->where('status','<>',3)
            ->where('status','<>',13)
            ->orderBy('created_at', 'ASC')
            ->paginate(20);

        }
        else{
        $products = null;
        }
        $productset = Product::
        whereIn('catorder_id', $teammate)
            ->whereIn('pack_id', $packs)
            ->whereIn('id',$messages)
            ->where('user_id',$user->id)
            ->where('status',12)
            ->where('status','<>',7)
            ->where('status','<>',11)
            ->where('status','<>',10)
            ->where('status','<>',9)
            ->where('status','<>',8)
            ->where('status','<>',5)
            ->where('status','<>',4)
            ->where('status','<>',3)
            ->where('status','<>',13)
            ->orderBy('created_at', 'ASC')
            ->first();

        $team = \App\frontmodels\Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();
        return view('front.workboard.productmessage',compact('user','products','team','protranslatescount','productset'));
    }

    public function searchproductMessage(Request $request)
    {
        $query = $request->input('codepro');
        $user = Auth::user();
        $messages = Message::where('user_id',$user->id)->pluck('product_id')->all();
        $teammates = \App\frontmodels\Teammate::with('user')->where('user_id', $user->id)->first();
        if ($teammates) {
            $teammate = $teammates->groups()->pluck('catorder_id')->all();
            $packs = $teammates->packs()->pluck('pack_id')->all();
            $products = Product::
            whereIn('catorder_id', $teammate)
                ->whereIn('pack_id', $packs)
                ->whereIn('id',$messages)
                ->where('codepro',$query)
                ->where('user_id',$user->id)
                ->where('status',12)
                ->where('status','<>',7)
                ->where('status','<>',11)
                ->where('status','<>',10)
                ->where('status','<>',9)
                ->where('status','<>',8)
                ->where('status','<>',5)
                ->where('status','<>',4)
                ->where('status','<>',3)
                ->where('status','<>',13)
                ->orderBy('created_at', 'ASC')
                ->paginate(20);
        }

        else{
            $products = null;
        }
        $productset = Product::
        whereIn('catorder_id', $teammate)
            ->whereIn('pack_id', $packs)
            ->whereIn('id',$messages)
            ->where('user_id',$user->id)
            ->where('status',12)
            ->where('status','<>',7)
            ->where('status','<>',11)
            ->where('status','<>',10)
            ->where('status','<>',9)
            ->where('status','<>',8)
            ->where('status','<>',5)
            ->where('status','<>',4)
            ->where('status','<>',3)
            ->where('status','<>',13)
            ->orderBy('created_at', 'ASC')
            ->first();
//        dd($products);
        $team = \App\frontmodels\Teammate::where('user_id',Auth::id())->first();
        $protranslatescount = Protranslate::count();
        return view('front.workboard.searchproductmessage',compact('user','products','team','protranslatescount','productset'));
    }
}
