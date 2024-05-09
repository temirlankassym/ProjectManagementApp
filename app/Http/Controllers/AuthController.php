<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserCreateRequest $request){
        $data = $request->validated();
        $user = User::create($data);

        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $data = $request->validated();
        $user = User::where("email","$data[email]")->first();

        if(!$user || !Hash::check($data["password"],$user->password))
            return view('auth.login',["error"=>"Password or email is incorrect"]);

        auth()->login($user);

        return redirect('/home');
    }

    public function logout(){
        auth()->logout();
        return redirect('/login');
    }
}
