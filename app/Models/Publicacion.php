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

    public function user(){
        return $this->BelongsTo(User::class);
    }

    public function imagen(){
        return $this->morphMany(Imagen::class,'imageable');
    }

    /////////////////////////END RELACIONES/////////////////////

}
