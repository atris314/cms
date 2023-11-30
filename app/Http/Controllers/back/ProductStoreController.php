<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Coupon;
use App\Http\Controllers\Controller;
use App\Mail\ProductConfirm;
use App\Mail\TeamConfirm;
use App\Models\Catorder;
use App\Models\Pack;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Teammate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ProductStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('status',0)
            ->where('status','<>','14')
            ->orderBy('created_at','DESC')
            ->paginate(30);
        $packs = Pack::all()->pluck('title','id');
        //dd($products);
        return view('back.productstore.productstore',compact('products','packs'));
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
        return view('back.productstore.show',compact('user','packs','catorders','coupon','product'));
    }
    public function productprint(Product $product)
    {
        $user = Auth::user();
        $packs = Pack::all();
        $catorders =Catorder::all()->pluck('title','id');
        return view('back.productstore.productstoreprint',compact('product','user','packs','catorders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('back.productstore.edit',compact('product'));
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


        $product->update([
            'status' => $request->input('status'),
        ]);

        try{
            $product->save();

        }catch (Exception $exception){
            return redirect(route('back.productstore.edit',$product->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! وضعیت سفارش تغییر کرد.' ;
        return redirect(route('back.productstore'))->with('success',$msg);
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
                return redirect(route('back.productstore'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.productstore'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }

    public function productSearch(Request $request)
    {
        $query = $request->input('pack_id');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::with('pack')
            ->where('pack_id','like' , "%".$query."%")
            ->where('status',0)
            ->paginate(20);

       // dd($products);
        return view('back.productstore.search',compact('products','query','packs'));
    }

    public function productCodeSearch(Request $request)
    {
        $query = $request->input('codepro');
        //dd($query);
        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('codepro','like' , "%".$query."%")
            ->where('status',0)
            ->paginate(20);

        //dd($products);
        return view('back.productstore.code-search',compact('products','query','packs'));
    }
    public function sotreuserCodeSearch(Request $request)
    {
        $query = $request->input('code');

        $user = User::where('code',$query)->first();

        $packs = Pack::all()->pluck('title','id');

        $products = Product::where('user_id',$user->id)->where('status',0)
            ->paginate(30);

//        dd($products);
        return view('back.productstore.user-search',compact('products','query','packs'));
    }

}
