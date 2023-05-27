<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Furniture;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){

        $user = auth()->user()->id;

        $check = Cart::where('user_id', $user)->get();

        $total = 0;

        

        foreach($check as $checks){
            $total = $total + $checks->subtotal;
            
        }

        return view('dashboard.user.cart', [
            "title" => "Cart",
            "total" => $total,
            "cart" => $check
        ]);
    }

    public function store(Cart $cart, $id){


        $furniture = Furniture::find($id);
        $user = auth()->user()->id;
        $check = Cart::where([
            ['user_id', $user],
            ['furniture_id', $id]
        ])->first();

        
        if($check==TRUE){
            $quantity = $check->quantity+1;
            $total = $check->price*$quantity;
            $check->update([
                'name' => $furniture->name,
                'price' => $furniture->price,
                'quantity' => $quantity,
                'subtotal' => $total,
                'image' => $furniture->image,
                'user_id' => $user,
                'furniture_id' => $id
            ]);

            return redirect('/')->with('success', 'Success To Add Furniture');

        }
        else{
            $cart->create([
                'name' => $furniture->name,
                'price' => $furniture->price,
                'quantity' => 1,
                'subtotal' => $furniture->price,
                'image' => $furniture->image,
                'user_id' => $user,
                'furniture_id' => $id
            ]);
            return redirect('/')->with('success', 'Success To Add Furniture');
        }
    
    }

    public function add(Request $request,Cart $cart, $id){


        $furniture = Furniture::find($id);
        $user = auth()->user()->id;

        $check = Cart::where([
            ['user_id', $user],
            ['furniture_id', $id]
        ])->first();

        
        if($check==TRUE){
            $quantity = $check->quantity+$request->jumlah;
            $total = $check->price*$quantity;
            $check->update([
                'name' => $furniture->name,
                'price' => $furniture->price,
                'quantity' => $quantity,
                'subtotal' => $total,
                'image' => $furniture->image,
                'user_id' => $user,
                'furniture_id' => $id
            ]);

            return redirect('/')->with('success', 'Success To Add Furniture To Your Cart');

        }
        else{
            $total = $furniture->price*$request->jumlah;
            $cart->create([
                'name' => $furniture->name,
                'price' => $furniture->price,
                'quantity' => $request->jumlah,
                'subtotal' => $total,
                'image' => $furniture->image,
                'user_id' => $user,
                'furniture_id' => $id
            ]);
            return redirect('/')->with('success', 'Success To Add Furniture To Your Cart');
        }
    
    }

    public function update(Request $request, $id){

        $cart = Cart::find($id);

        $subtotal = $cart->price * $request->jumlah;

        $cart->update([
            'quantity' => $request->jumlah,
            'subtotal' => $subtotal
        ]);

        return redirect('/cart')->with('success', 'Success To Add Furniture');

    }

    public function destroy($id){

        Cart::destroy($id);

        return redirect('/cart')->with('success', 'Success To Delete 1 Furniture');

    }

}
