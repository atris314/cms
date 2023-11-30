<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request,$id)
    {
        $product = Product::findOrFail('id');
        $oldCart = Session::hss('cart')? Session::get('cart') :null ;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart' , $cart);

        dd($request->session()->get('cart'));
        return back();
    }
}
