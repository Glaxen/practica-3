<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserContoller extends Controller
{
    public function login(Request $request){
        $credencioalles = $request->only('email','password');
        if (Auth::attempt($credencioalles)){
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json(['token'=>$token,'user'=>$user]);
        }else{
            return response()->json(['error'=>'No autorizado']);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken() ->delete();
        return response()->json(['message'=>'logged out'])
;   }
}
