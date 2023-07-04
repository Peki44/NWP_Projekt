<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addproduct(){
        $categories=Category::All()->pluck('category_name','category_name');
        return view('admin.addproduct')->with('categories',$categories);
    }
    public function products(){
        $products=Product::All();


        return view('admin.products')->with('products',$products);
    }
    public function saveproduct(Request $request){
        $this->validate($request,['product_name'=> 'required',
                                  'product_price'=>'required',
                                  'product_category'=>'required',
                                  'product_image'=>'image|nullable|max:1999']);

        
        if($request->hasFile('product_image')){
            $fileNameWithExt=$request->file('product_image')->getClientOriginalName();
            $fileName=pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension=$request->file('product_image')->getClientOriginalExtension();
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            $path=$request->file('product_image')->storeAs('public/product_images',$fileNameToStore);
        }else{
            $fileNameToStore='noimage.jpg';
        }
        $product=new Product();
        $product->product_name=$request->input('product_name');
        $product->product_price=$request->input('product_price');
        $product->product_category=$request->input('product_category');
        $product->product_image=$fileNameToStore;
        $product->save();

        return back()->with('status','Saved successfully');
    }
}
