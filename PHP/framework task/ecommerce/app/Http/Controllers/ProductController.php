<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return view('dashboard.product.index', [
            'title' => 'Furniture Freedom | Product',
            'furniture' => Furniture::all()

        ]);
    }

    public function show($id){
        return view('dashboard.product.detail', [
            'title' => 'Furniture Freedom | Detail Product',
            'furniture' => Furniture::find($id),
            'furnitures' => Furniture::latest()->limit(4)->get()
        ]);
    }

    public function find($type){
        return view('dashboard.product.type', [
            'title' => 'Furniture Freedom | Detail Product',
            'active' => 'view',
            'furniture' => Furniture::all($type)
        ]);
    }
}
