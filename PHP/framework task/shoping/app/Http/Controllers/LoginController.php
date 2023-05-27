<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function index(){
        return view('login.index', [
            'title' => 'Furniture Freedom | Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        $remember_me = $request->remember ? true : false;

        if(Auth::attempt($credentials, $remember_me)){

            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Your Email Or Password Is Wrong. Please Try Again');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    
}
