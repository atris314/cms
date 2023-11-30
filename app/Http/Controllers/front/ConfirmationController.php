<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Product;
use App\frontmodels\User;
use App\Http\Controllers\Controller;
use App\Models\Confirmation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id',$user->id)->pluck('id')->all();

        $confirmations = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->paginate(30);

        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();

        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.confirmation-list',compact('confirmations','user','productcount','confirmationset'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Confirmation $confirmation)
    {
//        dd($confirmation);
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return  view('front.dashboard.confirmation-show',compact('confirmation','user','productcount'));
    }

    public function edit(Confirmation $confirmation)
    {
        //
    }

    public function update(Request $request, Confirmation $confirmation)
    {
        $messages = [
            'confirm.required' => 'لطفا تیک تطابق اطلاعات را فعال کنید',
        ];
        $validateData = $request->validate([
            'confirm' => 'required',
        ],$messages);
        $confirmation->confirm = $request->input('confirm');
//        $product = Product::where('codepro',$confirmation->product->codepro)->first();
//        $product->status = 16;
        try{
            $confirmation->update();
        }catch (Exception $exception){
            return redirect(route('confirmation.show',$confirmation->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم !مطابقت اطلاعات ذکر شده با سفارش ثبت شده تایید شد، امضای الکترونیکی شما ثبت شد' ;
        return redirect(route('oldproduct'))->with('success',$msg);
    }

    public function confirmPrint(Confirmation $confirmation)
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        return view('front.dashboard.confirmPrint',compact('confirmation','user','productcount'));
    }
}
