<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $fillable=[
        'body'
    ] ;

    /////////////////////////RELACIONES/////////////////////

    public function likedBy(User $usuario){
        return $this->likes->contains('user_id',$usuario->id);
    }

    public function user(){
        return $this->BelongsTo(User::class);
    }

    public function imagen(){
        return $this->morphMany(Imagen::class,'imageable');
    }

    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }

    public function comentarios(){
        return $this->morphMany(Comentario::class,'comentarioable')->whereNull('parent_id');
    }

    /////////////////////////END RELACIONES/////////////////////

}
