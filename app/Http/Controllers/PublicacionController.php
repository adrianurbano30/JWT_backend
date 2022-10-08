<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacion;
use App\Http\Resources\PublicacionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function show(Publicacion $publicacion)
    {
        return Publicacion::finOrFail($publicacion->id);
    }

    public function update(Request $request, Publicacion $publicacion)
    {
        //
    }

    public function destroy(Publicacion $publicacion)
    {
        $post = Publicacion::find($publicacion->id);

        return $post->destroy();
    }
}
