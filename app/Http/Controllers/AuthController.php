<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $val=$request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'role'=>''
        ]);
        $user=User::create($val);
        $token=$user->createToken($user->name);
        $data=[
            'response'=>201,
            'message'=>'created',
            'token'=>$token
        ];
        return response()->json($data,201);
    }
    public function login(Request $request){
        $val=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json('something is wrong',400);
        }
        $token=$user->createToken($user->name);
        $data=[
            'response'=>200,
            'message'=>'you are connected',
            'token'=>$token
        ];
        return response()->json($data,200);
    }
    public function logout(Request $request){

    }
}
