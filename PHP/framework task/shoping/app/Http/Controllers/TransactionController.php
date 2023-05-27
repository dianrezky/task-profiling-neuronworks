<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller{

    //

    public function index($id){

        $user = User::find($id);

        $check = Cart::where('user_id', $user->id)->get();

        $total = 0;

        foreach($check as $checks){
            $total = $total + $checks->subtotal;
            
        }

        return view('dashboard.user.checkout', [
            "title" => "Furniture Freedom | Checkout",
            "total" => $total,
            "cart" => $check,
            "user" => $user
        ]);
    }

    public function store(Request $request, Transaction $transaction, $id){

        //$user = auth()->user()->id;

        $check = Cart::where('user_id', $id)->get();

        $validatedData = $request->validate([
            'card' => 'required|min:16|max:16',
            'method' => 'required'
        ]);

        $total = 0;
        $num_trans = 0;

        foreach($check as $checks){
            $total = $total + $checks->subtotal;
            
        }

        $check_trans = Transaction::Where('user_id', $id)->first();


        if($check_trans==NULL){

            foreach($check as $save){
            
                $transaction->create([
                    'name' => $save->name,
                    'price' => $save->price,
                    'quantity' => $save->quantity,
                    'subtotal' => $save->subtotal,
                    'total' => $total,
                    'image' => $save->image,
                    'user_id' => $save->user_id,
                    'furniture_id' => $save->furniture_id,
                    'num_transaction' => 1,
                    'method' => $validatedData['method'],
                    'card_number' => $validatedData['card']

                ]);
            }
            
            Cart::where('user_id', $id)->delete();

            return redirect('/')->with('success', 'Your Order Has Been Process.');
        }
        else{


            $check_num = Transaction::Where('user_id', $id)->get();

            foreach($check_num as $num){
                $num_now = $num->num_transaction;
            }
    
            $num_trans = $num_now+1;

            foreach($check as $save){
            
                $transaction->create([
                    'name' => $save->name,
                    'price' => $save->price,
                    'quantity' => $save->quantity,
                    'subtotal' => $save->subtotal,
                    'total' => $total,
                    'image' => $save->image,
                    'user_id' => $save->user_id,
                    'furniture_id' => $save->furniture_id,
                    'num_transaction' => $num_trans,
                    'method' => $validatedData['method'],
                    'card_number' => $validatedData['card']
                ]);
            }

            Cart::where('user_id', $id)->delete();

            return redirect('/')->with('success', 'Your Order Has Been Process. Thank You For Order In Furniture Freedom');
            
        }

        
    }

    public function detail($id){

       
        $user = auth()->user()->id;
        $transaction = Transaction::where([
            ['user_id', $user],
            ['num_transaction', $id]
        ])->get();

        $info_transaction = Transaction::where([
            ['user_id', $user],
            ['num_transaction', $id]
        ])->first();

        $info_user = User::find($user);

        return view('dashboard.user.detail_history', [
            "title" => "Furniture Freedom | Transaction History",
            "history" => $transaction,
            "info" => $info_transaction,
            "user" => $info_user
        ]);

    }

    public function show_user(){


        $user = auth()->user()->id;

        //$chart = Transaction::where('user_id', $user)->with('num_transaction')->get();
        $chart = Transaction::select('num_transaction', DB::raw('count(*) as total'))
                 ->groupBy('num_transaction')->where('user_id', $user)
                 ->get();

        $num = 0;

        foreach($chart as $chart){
            $num = $num +1;
        }


        return view('dashboard.user.history', [
            "title" => "Furniture Freedom | Transaction History",
            "history" => $num
        ]);

    }

    // ADMIN

    public function index_admin(){

        $this->authorize('admin');
        $user = User::where('is_admin', 'Member')->get();        

        return view('dashboard.admin.transaction.index', [
            "title" => "Furniture Freedom | Transaction History",
            "user" => $user
        ]);

    }

    public function show_admin($id){

        $this->authorize('admin');
        
        $chart = Transaction::select('num_transaction', DB::raw('count(*) as total'))
                 ->groupBy('num_transaction')->where('user_id', $id)
                 ->get();

        $num = 0;

        foreach($chart as $chart){
            $num = $num +1;
        }


        return view('dashboard.admin.transaction.history', [
            "title" => "Furniture Freedom | Transaction History",
            "history" => $num,
            'user' => $id
        ]);

    }

    public function detail_admin(Request $request, $id){

        $this->authorize('admin');

        $id_user = $request->id;

        $transaction = Transaction::where([
            ['user_id', $id_user],
            ['num_transaction', $id]
        ])->get();

        $info_transaction = Transaction::where([
            ['user_id', $id_user],
            ['num_transaction', $id]
        ])->first();

        $info_user = User::find($id_user);

        return view('dashboard.admin.transaction.detail_history', [
            "title" => "Furniture Freedom | Transaction History",
            "history" => $transaction,
            "info" => $info_transaction,
            "user" => $info_user
        ]);

    }

}
