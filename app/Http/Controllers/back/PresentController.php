<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Mail\ProductSentUser;
use App\Mail\releasepriceSentUser;
use App\Models\Admin;
use App\Models\Nextpayment;
use App\Models\Pack;
use App\Models\Payment;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Present;
use App\Models\Product;
use App\Models\Protranslate;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presents = Present::OrderBy('created_at','DESC')->paginate(120);
        $payments= Nextpayment::with('ordernextpay')->where('status',1)->orderBy('created_at','DESC')->paginate(120);
//        dd($payments);
        return view('back.presents.presents',compact('presents','payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Protranslate $protranslate)
    {
        $products = Product::all()->pluck('codepro','id');
        $pro = Product::where('id',$protranslate->product_id)->first();
        $codpro = $pro->codepro;
        $product_id = $pro->id;
        $user = User::where('id',$pro->user_id)->first();
//        dd($user);
        return view('back.presents.create',compact('products','codpro','product_id','user'));
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
            'deliverytime.required' => ' لطفا زمان تحویل سفارش را وارد نمایید',
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'price.required' => ' لطفا هزینه خرید کالا را وارد نمایید',
            'price.integer' => 'هزینه خرید کالا باید به صورت اعداد انگلیسی وارد شود',
            'photos.required' => ' لطفا تصویر سفارش را وارد نماييد',

        ];
        $validateData = $request->validate([
            'deliverytime' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'photos' => 'required',
        ],$messages);

        $develope = Admin::first();
        $present = new Present();

//        if ($file = $request->file('photo_id'))
//        {
//            $name = time().$file->getClientOriginalName();
//            $files= $file->move(public_path('images'),$name);
//            $photo = new Photo();
//            $photo->name =$files;
//            $photo->path = $name;
//            $photo->user_id = Auth::id();
//            $photo ->save();
//            $present->photo_id = $photo->id;
//        }
        $value = $request->input('product_id');
        $product = Product::where('id',$value)->first();
//        $productcode = $product->codepro;
        $user = User::where('id',$product->user_id)->first();
        $protranslate= Protranslate::where('product_id',$product->id)->first();
        $protranslate->status = 0;
        //dd($protranslate);

        $present->deliverytime = $request->input('deliverytime');
        $present->quick = $request->input('quick');
        $present->quickprice = $request->input('quickprice');
        $present->currency = $request->input('currency');
        $present->description = $request->input('description');
        $present->product_id = $request->input('product_id');
        $present->productcode=$request->productcode;
        $present->user_id= $user->id;
        $photos = explode(',', $request->input('photos')[0]);

        $present->price = $request->input('price');
        $present->releaseprice = $request->input('releaseprice');

        $packprice = $product->pack->price;
        $price =$present->price;
        $releaseprice = $present->releaseprice;
        $present->totalprice = null;
        $present->save();

        $product->status = '3';
        $product->save();

        $presents = Present::where('product_id',$present->product_id)->first();

        //dd($presents);

        Mail::to([$user->email])
            ->send(new ProductSentUser($presents , $user, $product , $photos, $request));
        $link = route('productshow',$product->id);
//        dd($request);
        try{
            if (isset($request->input('photos')[0])) {
                $present->photos()->attach($photos);
            }
            $protranslate->save();
//            if ($user->mobile){
//                $receptor = $user->mobile;
//                $type = 1;
//                $template = "ProductSentUser";
//                $param1 = $user->username;
//                $param2 = $present->productcode;
//                $param3 = $link;
//                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                $api->Verify($receptor, $type, $template,$param1,$param2,$param3);
//
//            }
        }catch (Exception $exception){
            return redirect(route('back.presents.create',$protranslate->id))->with('warning',$exception->getCode());
        }
        catch(\Ghasedak\Exceptions\ApiException $e){
            echo $e->errorMessage();
        }
        catch(\Ghasedak\Exceptions\HttpException $e){
            echo $e->errorMessage();
        }
        $msg = 'متشکرم! اطلاعات فرم با موفقیت ارسال شد' ;
        return redirect(route('back.presents'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function show(Present $present)
    {
        $product = Product::where('id',$present->product_id)->first();
        $packprice = $product->pack()->pluck('price')->first();
        $price = $present->price;
        $releaseprice = $present->releaseprice;
        $totalprice = ($price+$releaseprice)-$packprice;
        //dd($totalprice);
        return view('back.presents.show',compact('present','packprice','totalprice'));
    }
    public function presentsprint(Present $present)
    {
        $user = Auth::user();
        $product = Product::where('id',$present->product_id)->first();
        $packprice = $product->pack()->pluck('price')->first();
        $price = $present->price;
        $releaseprice = $present->releaseprice;
        $totalprice = ($price+$releaseprice)-$packprice;
        return view('back.presents.presentsprint',compact('present','user','packprice','totalprice'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function edit(Present $present)
    {
        return view('back.presents.edit',compact('present'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Present $present)
    {
        $messages = [
        ];
        $validateData = $request->validate([
        ],$messages);

        $develope = Admin::first();


        $product = Product::where('id',$present->product_id)->first();
        $user = User::where('id',$present->user_id)->first();
        //dd($protranslate);
        $present->quick = $request->input('quick');
        $present->quickprice = $request->input('quickprice');
        $present->currency = $request->input('currency');
        $present->deliverytime = $request->input('deliverytime');
        $present->description = $request->input('description');
        $present->price = $request->input('price');
        $present->releaseprice = $request->input('releaseprice');
        $packprice = $product->pack->price;
        $price =$present->price;
        $releaseprice = $present->releaseprice;
        $present->totalprice = null;

        if ($releaseprice){
            $present->status = 3 ;
            $product->status = '10';
            $product->save();
            Mail::to([$develope->email,$user->email])
                ->send(new releasepriceSentUser($present , $user, $product , $request));

        }
//        dd($present);
        try{
            //$present->photos()->attach($photos);
            $present->update();

        }catch (Exception $exception){
            return redirect(route('back.presents.edit',$present->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم! اطلاعات فرم با موفقیت ویرایش شد' ;
        return redirect(route('back.presents'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function destroy(Present $present)
    {
        try{
            $present->delete();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'حذف شد' ;
        return back()->with('success',$msg);
    }

    public function presentCodeSearch(Request $request)
    {
        $query = $request->input('productcode');


        $presents = Present::where('productcode',$query)->paginate(20);

        //dd($presents);
        return view('back.presents.present-search',compact('presents','query'));
    }


}
