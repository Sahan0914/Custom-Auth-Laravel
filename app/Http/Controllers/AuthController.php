<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //Register
    public function register(Request $request){
        // echo "<h1> P M</h1>";
        if ($request->isMethod("post")){ 
            $request->validate([
                "name"=>"required|string",
                "email"=>"required|email|unique:users",
                "phone"=>"required",
                "password"=>"required",
            ]);
            User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password' => bcrypt($request->password),
        'phone' => $request->phone
            ]);
            //Redirect auto login to dashboard
            if(Auth::attempt([
                "email"=>$request->email,
                "password"=>$request->password

            ])){
                return to_route('dashboard');
            }else{
                return to_route('register');
            }
        }
        return view('auth.register');

    }
    public function login(Request $request){
        // echo "<h1> L M</h1>";
        if ($request->isMethod("post")){ 
            $request->validate([
                "email"=>"required|email",
                "password"=>"required",
            ]);
            if(Auth::attempt([
                "email"=>$request->email,
                "password"=>$request->password

            ])){
                return to_route('dashboard');
            } else{
                return to_route('login')->with("error","Invalid login details");
            }
        }
        return view('auth.login');


    }
    public function dashboard(){
        // echo "<h1> D M</h1>";
        return view('dashboard');

        
    }
    public function profile(Request $request){
        if ($request->isMethod("post")){ 
            $request->validate([
                "name"=>"required|string",
                "phone"=>"required"
            
            ]);

        $id = Auth::user()->id;
        $user=User::findOrFail($id);
        
        $user->name=$request->name;
        $user->phone=$request->phone;
        $user->save();

        return to_route("profile")->with("success","Successfully,Profile updated");
       
        }
        // echo "<h1> PR M</h1>";
        return view('profile');

    }
    
    public function logout(){
        Session::flush();
        Auth::logout();
        return to_route("login")->with("success","Logged out successfully");

    }
}
  