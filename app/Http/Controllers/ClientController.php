<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function home(){
        $sliders=Slider::All()->where('status',1);
        $products=Product::All()->where('status',1);
        return view('client.home')->with('sliders',$sliders)->with('products',$products);
    }
    public function shop(){
        $categories=Category::All();
        $products=Product::All()->where('status',1);
        return view('client.shop')->with('categories',$categories)->with('products',$products);
    }
    public function cart(){
        return view('client.cart');
    }
    public function checkout(){
        return view('client.checkout');
    }
    public function login(){
        return view('client.login');
    }
    public function signup(){
        return view('client.signup');
    }
    public function orders(){
        return view('admin.orders');
    }
    public function create_account(Request $request){
        $this->validate($request,['email'=>'email|required|unique:clients',
                                  'password'=>'required|min:4']);
        $client=new Client();
        $client->email=$request->input('email');
        $client->password=bcrypt($request->input('password'));

        $client->save();
        return back()->with('status','Account created');
    }

    public function access_account(Request $request){
        $this->validate($request,['email'=>'email|required',
                                  'password'=>'required']);
        $client=Client::where('email',$request->input('email'))->first();
        if($client){
            if(Hash::check($request->input('password'),$client->password)){
                Session::put('client',$client);
                return redirect('/shop');
            }else{
                return back()->with('status','Wrong email or password');
            }
        }else{
            return back()->with('status','You do not have an account');
        }
    }
    public function logout(){
        Session::forget('client');
        return redirect('/shop');
    }
    
}
