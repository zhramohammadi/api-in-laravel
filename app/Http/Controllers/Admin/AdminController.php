<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('Admin.admin', compact('products'));
    }
    public function create(){
        return view('Admin.add-product');
    }

    public function store(Request $request){
        if($request->hasFile('image')){
            $filename = time(). '.' . $request->image->extension();
            $request->image->move(public_path('Images'),$filename);
            $inputs = $request->all();
            $inputs['image'] = $filename;
            Product::create($inputs);
            return redirect()->route('admin.index');
        }
    }


    public function delete($id)
    {
        $product = Product::Find($id);

        $image_path = "Images/$product->image";
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $product->delete($product);
        return redirect()->route('admin.index');

    }


    public function edit($id){
        $product =Product::Find($id);
        return view('Admin.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $product = Product::Find($id);
        if($request->hasFile('image')){
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('Images'),$filename);
            $inputs = $request->all();
            $inputs['image'] = $filename;
            $image_path = "Images/$product->image";
            if(File::exists($image_path)){
                File::delete($image_path);
            }
            $product->update($inputs);
            return redirect()->route('admin.index');
        }

    }
}
