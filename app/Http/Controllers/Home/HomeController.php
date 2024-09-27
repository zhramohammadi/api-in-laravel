<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::all();
        return view('Home.home', compact('products'));
    }

    public function login(){
        return view('Auth.login');
    }
    public function loginAdmin(Request $request) {
        $user = User::where('username', $request->username)->where('name',$request->name)->where('isAdmin', 1)->first();
        if ($user && Hash::check($request->password , $user->password)) {
            Auth::login($user);
            return redirect()->route('admin.index');
        } else {
            return abort(404);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }






    public function register(){
        return view('Auth.register');
    }

    public function registerUser(Request $request){
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('home');
    }
}
