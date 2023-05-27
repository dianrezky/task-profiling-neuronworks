<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        return view('home', [
            'title' => 'Furniture Freedom | Product',
            'furniture' => Furniture::all()

        ]);
    }
}
