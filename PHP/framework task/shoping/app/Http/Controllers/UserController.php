<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        $id_user = auth()->user()->id;
        return view('dashboard.user.index', [
            "title" => "User",
            "user" => User::find($id_user)

        ]);
    }

    public function edit($id){
        return view('dashboard.user.edit', [
            "title" => "User",
            "user" => User::find($id)
        ]);
    }

    public function update(Request $request, $id){

        $validatedData = $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u|min:2|unique:users',
            'email' => 'required|email:dns|max:255',
            'address' => 'required',
            'password' => 'required|min:5|max:255'
        ]);

        $user = User::find($id);
        
        // update data dengan kondisi jika email dan nama tidak sama seperti database
        if(($user->email != $validatedData['email'])&&($user->name != $validatedData['name'])){
            $validatedData_name = $request->validate(['name' => 'required|min:2|max:255|unique:users']);
            $validatedData_email= $request->validate(['email' => 'required|email:dns|max:255|unique:users']);
            $user->update([
                'name' => $validatedData_name['name'],
                'email' => $validatedData_email['email'],
                'password' => bcrypt($request->password),
                'address' => $request->address
            ]);
        }
        // update data dengan kondisi jika email sama seperti database
        else if( ($user->name != $validatedData['name']) && ($user->email == $validatedData['email'])){
            $validatedData_name = $request->validate(['name' => 'required|min:2|max:255|unique:users']);
            $user->update([
                'name' => $validatedData_name['name'],
                'password' => bcrypt($request->password),
                'address' => $request->address
            ]);
        }
        // update data dengan kondisi jika nama sama seperti database
        else if( ($user->name == $validatedData['name']) && ($user->email != $validatedData['email'])){
            $validatedData_email= $request->validate(['email' => 'required|email:dns|max:255|unique:users']);
            $user->update([
                'email' => $validatedData_email['email'],
                'password' => bcrypt($request->password),
                'address' => $request->address
            ]);
        }
        else if( ($user->name == $validatedData['name']) && ($user->email == $validatedData['email'])){
            $user->update([
                'password' => bcrypt($request->password),
                'address' => $request->address
            ]);
        }
        
        return redirect('/profile')->with('success','Data Has Been Updated!');
    }
}
