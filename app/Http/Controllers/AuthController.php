<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginRequest $request)
    {
        $request->validated($request->all());
        
        if(!Auth::attempt($request->only('email','password')))
        {
            return $this->error('','Credentials do not match',401);
        }
        $user=User::where('email',$request->email)->first();

        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API Token of '.$user->name)->plainTextToken
        ]);

    }
    public function register(UserStoreRequest $request)
    {
        $request->validated($request->all());
       $user=User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'password'=>Hash::make($request->password),
       ]);
         
       return $this->success([
        'user'=>$user,
        'token'=>$user->createToken('API Token'.$user->name)->plainTextToken
       ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' =>'you have successfully been logged out'
        ]);
    }
}
