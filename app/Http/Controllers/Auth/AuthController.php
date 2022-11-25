<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'foto_perfil' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:8|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }


        $usuario = User::create([
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'username' => $request->get('username'),
            'foto_perfil' => 'https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png' ,
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($usuario);

        return response()->json(compact('usuario','token'),201);

    }

    public function login(LoginRequest $Lrequest)
    {

        $credentiales = $Lrequest->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentiales)) {
                return response()->json(['error' => 'Correo o Contraseña invalidos'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'no se creo el TOKEN'], 500);
        }


        //return response()->json(compact('token'));

        $user = Auth::user();
        return response()->json([
            'token'=> $token,
            'usuario'=> $user,
        ]);

    }

    public function getUsuarioAutenticado()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }

            //return response()->json(compact('usuario','token'),201);

            return response()->json([
                'user'=>$user,
            ]);
    }

    public function logout(Request $request)
    {

        // $this->logHistory();
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
              'status' => 'hecho',
              'msg' => 'haz cerrado sesion exitosamente.'
            ]);
          } catch (JWTException $e) {
              JWTAuth::unsetToken();
              // something went wrong tries to validate a invalid token
              return response()->json([
                'status' => 'error',
                'msg' => 'Cierre de sesion fallida, Intenta de nuevo.'
            ]);
          }

           //  Auth::logout();

        //  return response()->json([
        //      'status' => 'success',
        //      'message' => 'Sesión terminada',
        //  ]);

    }

    public function checkEmail($email){

        $usuario = User::select('*')->where('email',$email)->get();

        if ($usuario->count()>0) {
            return response()->json(
                [
                  'mensaje'=>'TRUE'
                ]
            );
        }else{
            return response()->json(
                [
                'mensaje' => 'FALSE'
                ]
            );
        }
    }

    public function checkUsername($username){

        $usuario = User::select('*')->where('username',$username)->get();
        if ($usuario->count()>0) {
            return response()->json(
                [
                  'mensaje'=>'TRUE'
                ]
            );
        }else{
            return response()->json(
                [
                  'mensaje' => 'FALSE'
                ]
            );
        }

    }



}
