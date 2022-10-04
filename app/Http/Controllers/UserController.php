<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $usuario = User::all();
        return response()->json($usuario);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($user)
    {
        return User::find($user);
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

    public function update(Request $request, User $user)
    {
        //
    }


    public function destroy(User $user)
    {
        //
    }
}
