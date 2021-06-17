<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;

class CartController extends Controller
{
    public function add(Request $request)
    {
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
            )
        ));
        $notification = array(
            'message' => 'Product is Added to Cart!', 
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function clear(){
        \Cart::clear();
        $notification = array(
            'message' => 'Cart is Clear!', 
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        $notification = array(
            'message' => 'Product is Removed!', 
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }

    public function update(Request $request){
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
        $notification = array(
            'message' => 'Cart is Updated!', 
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);
    }
}
