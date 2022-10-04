<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ImagenController;




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
    Route::get('get_publicaciones',[PublicacionController::class,'index']);
    Route::post('make_publicacion',[PublicacionController::class,'store']);
    Route::get('get_publicacion/{id}',[PublicacionController::class,'show']);
    Route::delete('destroy_post/{id}',[PublicacionController::class,'index']);
    /////////////////////////////////////////

    //////////////IMAGENES/////////////////////////
    Route::get('get_imagen/{id}',[ImagenController::class,'show']);
    ///////////////////////////////////////
});


