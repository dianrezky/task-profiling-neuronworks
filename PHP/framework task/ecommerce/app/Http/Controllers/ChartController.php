<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Furniture;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index(){

        $user = auth()->user()->id;
        return view('dashboard.user.cart', [
            "title" => "Chart",
            "cart" => Chart::all()

        ]);
    }

    public function store(Chart $chart, $id){


        $furniture = Furniture::find($id);
        $user = auth()->user()->id;
        // $check = Chart::find

        $chart->create([
            'name' => $furniture->name,
            'price' => $furniture->price,
            'quantity' => 1,
            'total' => $furniture->price,
            'image' => $furniture->image,
            'user_id' => $user,
            'furniture_id' => $id
        ]);

        return redirect('/')->with('success', 'Success To Add Furniture');
    
    
    }
}
