<?php


namespace App\Http\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Route;


class CartHelper
{

	public static function addItem($data)
	{
	    if(Session::has('cart')){
	        $cartItems = Session::get('cart');
	    }else{
	        $cartItems = [];
	    }

	    if(isset($cartItems[$data['item_id']])){
	        $cartItems[$data['item_id']]['order_quantity'] += $data['order_quantity'];
//	        $cartItems[$data['item_id']]['unit_price'] += $data['unit_price'];
	    }else{
	        $cartItems[$data['item_id']] = $data;
	    }

	    $newItem = CartHelper::calculateCart($cartItems);
	    return $newItem;
	}



	protected static function calculateCart($cartItems){
	    $cart_total = [];

	    $newItem = [];
	    $cart_total['total'] = 0;

	    if(count($cartItems) > 0){
	        foreach ($cartItems as $item){
	            $item['order_quantity'] = $item['order_quantity'];
	            $item['subtotal'] = round($item['unit_price']*$item['order_quantity'],2);
//	            $cart_total['total'] += $item['subtotal'];
	            $newItem[$item['item_id']] = $item;
	        }
	    }

	    Session::put('cart',$newItem);
//	    Session::put('cart_total',$cart_total);
        return $newItem;
	}


	public static function remove_item($item_id){
	    if(Session::has('cart')){
	        $cartItems = Session::get('cart');
	    }else{
	        $cartItems = [];
	    }

	    if(isset($cartItems[$item_id])){
	        unset($cartItems[$item_id]);
	    }

	    $newItem = CartHelper::calculateCart($cartItems,true);
	    return $newItem;

	}


    public static function update($items){
        if(Session::has('cart')){
            $cartItems = Session::get('cart');
        }else{
            $cartItems = [];
        }

        if(isset($cartItems[$items['item_id']])){
            if($items['order_quantity'] > 0) {
//                $unitPrice = $cartItems[$items['item_id']]['item_price']/$cartItems[$items['item_id']]['item_quantity'];
                $cartItems[$items['item_id']]['order_quantity'] = $items['order_quantity'];
            }else{
                $cartItems[$items['item_id']]['order_quantity'] = 1;
            }
        }

        $newItem = CartHelper::calculateCart($cartItems);
        return $newItem;
    }


}
