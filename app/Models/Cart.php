<?php

namespace App\Models;


class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if($oldCart)
        {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totlalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id)
    {
        $storeditem = ['qty'=>0 , 'price' =>$item->price , 'item' =>$item];
        if ($this->items){
            if (array_key_exists($id, $this->items)){
                $storeditem = $this->items[$id];
            }
        }
        $storeditem['qty']++;
        $storeditem['price']= $item->price * $storeditem['qty'];
        $this->items[$id] = $storeditem;
        $this->totalQty ++;
        $this->totalPrice += $item->price;
    }
}
