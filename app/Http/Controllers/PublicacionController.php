<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacion;
use App\Models\Imagen;
use App\Http\Resources\PublicacionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PublicacionController extends Controller
{
    public function index()
    {
      $publicacion = Publicacion::latest()->get();
      Return PublicacionResource::collection($publicacion);
    }
    public function store(Request $request)
    {

         $usuario= Auth::user();
         $publicacion = $usuario->publicacion()->create([
             'body'=>$request->publicacion_body
         ]);
         //UN CAMBIO MAS PARA PROBAR EL GIT IGNORE
         if ($request->hasfile('images0')) {
            $img_publicacion_path='imagenes/publicaciones';
            for ($i=0; $i < $request->array_size ; $i++) {
                $fileIMG = $request->file('images'.$i);
                $img_publicacion_unica=rand(0,138541351551616815).'_'.time().'-'.$fileIMG->getClientOriginalName();
                $THEpath= $fileIMG->storeAs($img_publicacion_path,$img_publicacion_unica,'subidas_publicas');

                $img_publicacion_a_guardar=$THEpath;
                $publicacion->imagen()->create([
                  'url'=>$img_publicacion_a_guardar
                ]);
             }
         }
        return new PublicacionResource($publicacion);
    }
    public function update(Request $request)
    {
       $publicacion= Publicacion::find($request->publicacion_id);
       $usuario=$publicacion->user;
       $authUser=Auth::user();

       $publicacion->update([
        'body'=>$request->publicacion_body
       ]);
        $img;
       if ($request->img2delete) {
         for ($i=0; $i < $request->array_size2; $i++) {
              $img = json_decode($request->img2delete);
              $imagen=Imagen::find($img[$i]->id);
              $imagen->delete();
              File::delete(substr($img[$i]->url,24));
              //unlink($img[$i]->url);
         }
        }

       if ($request->hasfile('images0')) {
        $img_publicacion_path='imagenes/publicaciones';
        for ($i=0; $i < $request->array_size1 ; $i++) {
            $fileIMG = $request->file('images'.$i);
            $img_publicacion_unica=rand(0,138541351551616815).'_'.time().'-'.$fileIMG->getClientOriginalName();
            $THEpath= $fileIMG->storeAs($img_publicacion_path,$img_publicacion_unica,'subidas_publicas');
            $img_publicacion_a_guardar=$THEpath;
            $publicacion->imagen()->create([
              'url'=>$img_publicacion_a_guardar
            ]);
         }
        }

       return new PublicacionResource($publicacion);
    }
    public function show(Publicacion $publicacion)
    {
        return Publicacion::finOrFail($publicacion->id);
    }
    public function destroy(Request $request)
    {
         $publicacion = Publicacion::find($request->id);
         if ($publicacion->imagen) {
            for ($i=0; $i < count($publicacion->imagen); $i++) {
                File::delete($publicacion->imagen[$i]->url);
                $publicacion->imagen[$i]->delete();
            }
         }
         $publicacion->delete();
        return new PublicacionResource($publicacion);
    }

}
