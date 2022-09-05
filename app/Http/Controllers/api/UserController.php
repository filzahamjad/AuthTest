<?php

namespace App\Http\Controllers\api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    //register
    public function register(Request $request){
        $validator=Validator::make($request->all(),
        [
            'name'=>'required',
            'email'     =>'required|email|unique:users,email',
            'password'  =>'required',
        ]
        );

        if($validator->fails())
        {
            return response()->json(['status'=>false,'ErrorCode'=>400,'errors'=>$validator->messages()->all()],422);
        }
        $user = User::create([
            'name'         => $request->input('name'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
        ]);
        $status = $user->save();
        $user['access_token'] = $user->createToken('personal_access_tokens')->accessToken;
        return $status ? response()->json(['message'=>'You have been registered successfully !','data'=>$user],200): response()->json(['message'=>'Failed to create your account !'],422);
    }

    //login
    public function login(Request $request){
        $validator=Validator::make($request->all(),
        [
            'email'     =>'required|email|unique:users,email',
            'password'  =>'required',
        ]
        );

        if($validator->fails())
        {
            return response()->json(['status'=>false,'ErrorCode'=>400,'errors'=>$validator->messages()->all()],422);
        }
        $user = User::where(['email'=> strtolower($request->email)])->first();

        if(Hash::check(request()->password, $user->password)){
        Auth::login($user);
        $user['access_token'] = $user->createToken('access_token')->accessToken;
        return response()->json(['message'=>'Logged in successfully','data'=> $user],200);
        }
        else{
            return response()->json(['message'=>'Failed to login'],400);
        }

    }

    //logout
    public function logout(Request $request){
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['message'=>'User Logged out'],400);
    }

    //user
    public function User(Request $request){
        $user = User::where(['email'=> strtolower($request->email)])->first();
        $token['access_token'] = $user->createToken('access_token')->accessToken;
        return response()->json(['message'=>'new token','data'=> $token],200);
    }

    //Token
    public function Token(Request $request){
        $user = Auth::user();
        $data= User::select('password','email')->where('id', $user['id'])->get();
        $data['access_token'] = $user->createToken('access_token')->accessToken;
        return response()->json(['message'=>'user data','data'=> $data],200);
    }
}
