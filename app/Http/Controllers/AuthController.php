<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){

        /// Validacion de capmpos requeridos
        $validator= Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> 'required|string|min:8'
        ]);
        /// Si existe error en alguno de los campos devuelve JSON con errores de validación
        if($validator->fails()){
            return response()->json($alidator->errors());
        }
    

        /// Si la validación es pasada correctamente se crea el usuario
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email','password')))
        {   
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json([
                'message' => 'Welcome '.$user->name,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return['message'=> 'Cierre correcto - token eliminado'];
    }

}
