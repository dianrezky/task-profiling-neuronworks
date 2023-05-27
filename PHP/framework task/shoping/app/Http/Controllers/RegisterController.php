<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller{
    //
    public function index(){
        return view('register.index', [
            'title' => 'Furniture Freedom | Register',
            'active' => 'register'
            
        ]);
    }

    //function untuk menyimpan data

    public function store(Request $request){

        
        
        $validatedData = $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u|min:2|unique:users',
            'email' => 'required|email:dns|unique:users',
            'address' => 'required|min:5|max:95',
            'password' => 'required|min:5|max:20',
            'gender' => 'required'
        ]);

        if(preg_match('/[^a-z\s-]/i',$validatedData['name']));

        //mengencrypt password menggunakan bcrypt

        $validatedData['password'] = Hash::make($validatedData['password']);

        //save semua data yang ada di variabel validatedData kedalam database

        User::create($validatedData);

        //kembali ke halaman login dan menampilkan pesan sukses jika registrasi berhasil

        return redirect('/login')->with('success', 'Registration Successfull! Please Login');
    
    
    }

}
