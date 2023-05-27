<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //
    

    public function index(){
        $this->authorize('admin');
        return view('dashboard.admin.index',[
            'title' => "Furniture Freedom",
            "product" =>  Furniture::all()
        ]);
    }

    public function create(){
        $this->authorize('admin');
        return view('dashboard.admin.create',[
            'title' => "Furniture Freedom",
            "product" => Furniture::all()
        ]);
    }

    public function store(Request $request){
        $this->authorize('admin');
        $validatedData = $request->validate([
            'name' => 'required|unique:furniture|max:15',
            'price' => 'required|numeric|min:5000|max:10000000',
            'type' => 'required',
            'color' => 'required',
            'image' => 'image|required'
        ]);

        $validatedData['image'] = $request->file('image')->store('image-products');

        Furniture::create($validatedData);

        //kembali ke halaman login dan menampilkan pesan sukses jika registrasi berhasil
        //return $request->file('image')->store('post-products');
        return redirect('/furniture')->with('success', 'Success To Add 1 Furniture');
    
    
    }
    public function edit($id){
        $this->authorize('admin');
        return view('dashboard.admin.edit', [
            "title" => "Furniture Freedom | Edit",
            "furniture" => Furniture::find($id)

        ]);
    }

    public function update(Request $request, $id){

        $furniture = Furniture::find($id);

        $validatedData = $request->validate([
            'name' => 'required|max:15',
            'price' => 'required|numeric|min:5000|max:10000000',
            'type' => 'required',
            'color' => 'required',
            'image' => 'image'
        ]);

        $validatedData['image'] = $request->file('image');
        
        // update data dengan beberapa kondisi
        if(($validatedData['image']==NULL)&&($validatedData['name']==$furniture->name)){
            
            $furniture->update([
                'price' => $validatedData['price'],
                'type' => $validatedData['type'],
                'color' => $validatedData['color']
            ]);
        }
        else if(($validatedData['image']==NULL)&&($validatedData['name']!=$furniture->name)){
            $validatedData_name = $request->validate(['name' => 'required|max:15|unique:furniture']);
            $furniture->update([
                'name' => $validatedData_name['name'],
                'price' => $validatedData['price'],
                'type' => $validatedData['type'],
                'color' => $validatedData['color']
            ]);
        }
        else if(($validatedData['image']!=NULL)&&($validatedData['name']==$furniture->name)){
            $validatedData['image'] = $request->file('image')->store('image-products');
            Storage::delete($furniture->image);
            $furniture->update([
                'price' => $validatedData['price'],
                'type' => $validatedData['type'],
                'color' => $validatedData['color'],
                'image' => $validatedData['image']
            ]);
        }
        else if(($validatedData['image']!=NULL)&&($validatedData['name']!=$furniture->name)){
            $validatedData['image'] = $request->file('image')->store('image-products');
            $validatedData_name = $request->validate(['name' => 'required|max:15|unique:furniture']);
            Storage::delete($furniture->image);
            $furniture->update([
                'name' => $validatedData_name['name'],
                'price' => $validatedData['price'],
                'type' => $validatedData['type'],
                'color' => $validatedData['color'],
                'image' => $validatedData['image']
            ]);
        }

        return redirect('/furniture')->with('success',' Data telah diperbaharui!');
    }

    public function destroy($id){
        
        
        $furniture = Furniture::find($id);
        
        Storage::delete($furniture->image);
        
        Furniture::destroy($id);
        return redirect('/')->with('success',' Data telah dihapus!');
    }


}
