<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ComentarioController;




Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


/////CHECKEO DE EXISTENCIA DE EMAIL EN LA BD///////////////
Route::get('email_confirm/{data}',[UserController::class,'checkEmail']);

/////CHECKEO DE EXISTENCIA DE USERNAME EN LA BD///////////////
Route::get('username_confirm/{data}',[UserController::class,'checkUsername']);


Route::group(['middleware' => ['jwt.verify']], function() {


    //////USERS///////////////////////////

    Route::get('obtener_usuarios',[UserController::class,'index']);
    Route::get('obtener_usuario/{id}',[UserController::class,'show']);

    //////logout///////////////////////////
    Route::post('logout',[AuthController::class,'logout']);


    /////GET USUARIO LOGEADO///////////////////
    Route::get('usuariolog',[AuthController::class,'getUsuarioAutenticado']);
    /////////////////////////////////////


    ////PUBLICACIONES///////////////////////////////
    Route::post('make_publicacion',[PublicacionController::class,'store']);
    Route::post('actualizarPublicacion',[PublicacionController::class,'update']);
    Route::delete('eliminar_post/{id}',[PublicacionController::class,'destroy']);
    Route::get('get_publicaciones',[PublicacionController::class,'index']);
    Route::get('get_publicacion/{id}',[PublicacionController::class,'show']);
    /////////////////////////////////////////

    //LIKES///////////////////////////////////////
    Route::post('make_like',[LikeController::class,'storeLikePost']);
    Route::post('make_like_comentario',[LikeController::class,'storeLikeComment']);
    /////////////////////////////////////////////

    ///COMENTARIOS////////////////////////////////////
    Route::post('make_comentario',[ComentarioController::class,'storeComentario']);
    Route::post('response_comentario',[ComentarioController::class,'storeRespuestaComentario']);
    Route::put('update_comentario/{id}',[ComentarioController::class,'updateComentario']);
    Route::put('update_respuesta/{id}',[ComentarioController::class,'updateRespuestaComentario']);
    Route::delete('delete_comentario/{id}',[ComentarioController::class,'destroyComentario']);
    Route::delete('delete_respuesta/{id}',[ComentarioController::class,'destroyRespuesta']);
    /////////////////////////////////////////////////

    //////////////IMAGENES/////////////////////////
    Route::get('get_imagen/{id}',[ImagenController::class,'show']);
    ///////////////////////////////////////
});


