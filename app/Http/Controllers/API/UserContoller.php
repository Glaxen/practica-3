<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'logged out']);
    }

    public function register(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'DNI' => 'required|string|max:20|unique:users,dni',
        ];

        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'lastname.required' => 'El campo apellido es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'DNI.required' => 'El campo DNI es obligatorio.',
            'DNI.unique' => 'El DNI ya está registrado.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $validator->errors(),
            ]);
        }

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['message'=>'usuario creado con exito']);

    }
}
