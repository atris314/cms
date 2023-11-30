<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Coupon;
use App\Http\Controllers\Controller;
use App\Mail\ProductConfirm;
use App\Mail\TeamConfirm;
use App\Models\Admin;
use App\Models\Catorder;
use App\Models\Pack;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Protranslate;
use App\Models\Teammate;
use App\Models\User;
use App\Mail\Cancelpro;
use App\Mail\ProductEdit;
use App\Mail\ProductStore;
use App\Mail\Rerequest;
use App\Notifications\ProductAdd;
use DateTime;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use function Sodium\add;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->where('status','<>',0)->where('status','<>','15')
            ->paginate(30);
        $packs = Pack::all()->pluck('title','id');
        return view('back.products.products',compact('products','packs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $catorders = Catorder::all()->pluck('title','id');
        $packs = Pack::all();
        return view('back.products.create',compact('users','catorders','packs'));
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
            'title.required' => ' لطفا عنوان سفارش خود را وارد نمایید',
            'description.required' => ' لطفا توضیحی درباره سفارشتان بنویسید را وارد نمایید',
            'catorder_id.required' => 'لطفا دسته بندی را  تعيين كنيد ',
            'pack_id.required' => ' نوع منبع یابی را مشخص نکرده اید',
//            'termcheck.required' => 'لطفا تیک شرایط و قوانین را بزنید.',
            'number.required' => 'لطفا تعداد سفارش را مشخص کنید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'catorder_id' => 'required',
            'pack_id' => 'required',
//            'termcheck' => 'required',
            'number' => 'required',

        ],$messages);

        $product = new Product();
        $codepro = rand(10000, 20000);

        //$product['photo_id'] = $request->input('photo_id');
        $product->title = $request->input('title');
        $product->number = $request->input('number');
        $product->description = $request->input('description');
        $product->catorder_id = $request->input('catorder_id');
        $product->pack_id = $request->input('pack_id');
        $product->termcheck = 'yes';
        $product->partnumber = $request->input('partnumber');
        $product->isiran = 'dont-know';
        $product->codepro = $codepro;
        $product->user_id =$request->input('user_id');

        $product->status = 0;
        if ($pack_id = $request->input('pack_id'))
        {
            $amount = $product->pack()->pluck('price')->first();
        }
        $product->amount = $amount;
        $product->totalamount = $amount;
        $product->discountamount = 0;
        $photos = explode(',', $request->input('photos')[0]);

        $user_id = $request->input('user_id');
        $develope = Admin::first();
        $pack = Pack::where('id',$product->pack_id)->first();
        $catorder = Catorder::where('id',$product->catorder_id)->pluck('title')->first();

        $user = User::where('id',$user_id)->first();

        try{
            $product->save();
            if (isset($request->input('photos')[0])) {
                $product->photos()->sync($photos);
            }

//            Mail::to([$user->email,'yabane.managment@gmail.com'])
//                ->send(new ProductStore($user, $product ,$pack ,$catorder));

            $site = route('productshow',$product->id);
            if (isset($user->mobile)){
                $receptor = $user->mobile;
                $type = 1;
                $template = "productSent";
                $param1 = $codepro;
                $param2 = $site;
                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
                $api->Verify($receptor, $type, $template, $param1,$param2);
            }


            if ($users = \App\Models\User::whereHas('roles' , function($q){
                $q->where('role_id', '1' );
            })->get()) {
                Notification::send($users, new ProductAdd($product->title));
            }
        }
        catch (Exception $exception){
            return redirect(route('back.products.create'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سفارش ثبت شد در انتظار پرداخت هزینه منبع یابی می باشد.' ;
        return redirect(route('back.productstore'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $user = Auth::user();
        $packs = Pack::all();
        $catorders =Catorder::all()->pluck('title','id');
        $coupon = Coupon::where('status' , 1)->first();
        return view('back.products.show',compact('user','packs','catorders','coupon','product'));
    }
    public function productprint(Product $product)
    {
        $user = Auth::user();
        $packs = Pack::all();
        $catorders =Catorder::all()->pluck('title','id');
        return view('back.products.productprint',compact('product','user','packs','catorders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('back.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $messages = [
            'status.required' => ' لطفا وضعیت سفارش را وارد نمایید.',

        ];
        $validateData = $request->validate([
            'status' => 'required',
        ],$messages);

        $user = User::where('id',$product->user_id)->first();


        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $product->photo_id = $photo->id;
        }
//        dd($product);
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->number = $request->input('number');
        $product->partnumber = $request->input('partnumber');
        if ($request->input('status') == 2)
        {
            $product->timepayment =new DateTime("now");
        }


        try{
            $product->update();
            if ($product->status == 2){
                if ($product->pack_id == 1){
                    $user->rate +=40;
                    $user->update();
                }
                if ($product->pack_id == 2){
                    $user->rate +=30;
                    $user->update();
                }
                if ($product->pack_id == 3){
                    $user->rate +=10;
                    $user->update();
                }
            }
            if ($product->status == 4){
                $user->rate +=10;
                $user->update();
            }

        }catch (Exception $exception){
            return redirect(route('back.products.edit',$product->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! وضعیت سفارش تغییر کرد.' ;
        return redirect(route('back.products'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (Gate::allows('isAdmin')){
            try{
                $product->delete();
            }catch (Exception $exception){
                return redirect(route('back.products'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.products'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
    public function apiGetSortedProduct($id , $sort)
    {
        $products =Product::with('photos')->whereHas('categories',function ($q) use($id){
            $q->where('id',$id);
        })->orderBy($sort)
            ->paginate(3);
        $response=[
            'products' =>$products
        ];
        return response()->json($response,200);
    }

    public function productSearch(Request $request)
    {
        $query = $request->input('pack_id');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::with('pack')
            ->where('pack_id','like' , "%".$query."%")->orderBy('created_at','desc')->where('status','<>',0)->where('status','<>','15')
            ->paginate(20);

       // dd($products);
        return view('back.products.search',compact('products','query','packs'));
    }

    public function productCodeSearch(Request $request)
    {
        $query = $request->input('codepro');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('codepro','like' , "%".$query."%")->where('status','<>',0)->where('status','<>','15')
            ->paginate(20);

        //dd($products);
        return view('back.products.code-search',compact('products','query','packs'));
    }


    public function deleteAll(Request $request)
    {
        $products = Product::findOrFail($request->checkBoxArray);
        foreach ($products as $product){
//            $protranslate = Protranslate::Where('product_id',$product->id)->get();

            $product->delete();

        }
        $msg = 'سفازشات با موفقیت حذف شد' ;
        return redirect(route('back.products'))->with('success',$msg);
    }

    public function holdEdit()
    {
        $products = Product::orderBy('created_at','desc')->where('status',12)->where('status','<>','15')
            ->paginate(30);
        $packs = Pack::all()->pluck('title','id');
        //dd($products);
        return view('back.products.products-hold-edit',compact('products','packs'));
    }

    public function holdEditproductSearch(Request $request)
    {
        $query = $request->input('pack_id');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::with('pack')
            ->where('pack_id','like' , "%".$query."%")->orderBy('created_at','desc')->where('status',12)->where('status','<>','15')
            ->paginate(20);

        // dd($products);
        return view('back.products.holdsearch',compact('products','query','packs'));
    }

    public function holdEditproductCodeSearch(Request $request)
    {
        $query = $request->input('codepro');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('codepro','like' , "%".$query."%")->where('status',12)->where('status','<>','15')
            ->paginate(20);

        //dd($products);
        return view('back.products.holdcode-search',compact('products','query','packs'));
    }


    public function userCodeSearch(Request $request)
    {
        $query = $request->input('code');

        $user = User::where('code',$query)->first();

        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('user_id',$user->id)->where('status','<>',0)->where('status','<>','15')
            ->paginate(30);

//        dd($products);
        return view('back.products.user-search',compact('products','query','packs'));
    }
    public function holdedituserCodeSearch(Request $request)
    {
        $query = $request->input('code');

        $user = User::where('code',$query)->first();

        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('user_id',$user->id)->where('status',12)->where('status','<>','15')
            ->paginate(30);

//        dd($products);
        return view('back.products.user-search',compact('products','query','packs'));
    }

    public function cancel()
    {
        $products = Product::orderBy('created_at','desc')->where('status','15')
            ->paginate(30);
        $packs = Pack::all()->pluck('title','id');
        return view('back.products.cancel',compact('products','packs'));
    }


    public function cancelSearch(Request $request)
    {
        $query = $request->input('pack_id');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::with('pack')
            ->where('pack_id','like' , "%".$query."%")->orderBy('created_at','desc')->where('status','15')
            ->paginate(20);

        // dd($products);
        return view('back.products.search',compact('products','query','packs'));
    }

    public function cancelCodeSearch(Request $request)
    {
        $query = $request->input('codepro');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('codepro','like' , "%".$query."%")->where('status','15')
            ->paginate(20);

        //dd($products);
        return view('back.products.code-search',compact('products','query','packs'));
    }
    public function canceluserCodeSearch(Request $request)
    {
        $query = $request->input('code');

        $user = User::where('code',$query)->first();

        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('user_id',$user->id)->where('status','15')
            ->paginate(30);

//        dd($products);
        return view('back.products.user-search',compact('products','query','packs'));
    }

}
