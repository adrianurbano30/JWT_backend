<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'comentarios',
        'editado'
    ];

    public function likedBy(user $usuario){
        return $this->likes->contains('user_id',$usuario->id);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }
    public function comentarioable(){
        return $this->morphTo();
    }

    //relacion con sigo mismo//

    public function parent(){
        return $this->belongsTo(Comentario::class);
    }

    public function replies(){
        return $this->hasMany(Comentario::class,'parent_id');
    }

    //end relacion con sigo mismo

}
