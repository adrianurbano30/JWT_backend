<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacion;
use App\Http\Resources\PublicacionResource;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{

    public function index()
    {
      $publicacion = Publicacion::latest()->get();
      Return PublicacionResource::collection($publicacion);
    }

    public function store(Request $request)
    {

        //$usuario = User::find($request->user_id->id);

        $usuario= Auth::user();

        $url="DIR/DONDE/ESTA/img/Qllega.png";

        $publicacion = $usuario->publicacion()->create([
            'body'=>$request->body
        ]);
        $publicacion->imagen()->create([
            'url'=>$url
        ]);

        return response()->json(
            [
              'publicacion'=> $publicacion
            ]
        );
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
