<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LikeResource;
use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Models\Comentario;
use App\Models\Imagen;

class LikeController extends Controller
{

    public function storeLikePost(Request $request){

        $usuario=Auth::User();
        $publicacion=Publicacion::find($request[0]);
        //$like;


        if (!$publicacion->likedBy($usuario)) {

            $like = $publicacion->likes()->create([
                'user_id'=>$usuario->id
            ]);

            return new LikeResource($like);

         }else{

             $publicacion->likes()
             ->where('user_id',$usuario->id)
             ->delete();

            return 0;
         }
    }

    public function storeLikeComment(Request $request){

        $usuario=Auth::User();
        $comentario = Comentario::find($request->id);
        //$likeComentario;

        if (!$comentario->likedBy($usuario)) {

            $likeComentario = $comentario
            ->likes()
            ->create([
                'user_id'=>$usuario->id
            ]);

            return new LikeResource($likeComentario);

        }else{
            $comentario->likes()
            ->where('user_id',$usuario->id)
            ->delete();

            return 0;

        }

    }

    public function storeLikeImg(Request $request){
        $usuario=Auth::User();
        $imagen = Imagen::find($request->id);

        if (!$imagen->likedBy($usuario)) {

            $likeImagen = $imagen
                         ->likes()
                         ->create([
                            'user_id'=>$usuario->id
                         ]);
            return new LikeResource($likeImagen);

        }else{
            $imagen->likes()
            ->where('user_id',$usuario->id)
            ->delete();
            return 0;
        }

    }

}
