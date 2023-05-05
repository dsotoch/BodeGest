<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class clientes extends Model
{
   protected $fillable=[
    'dni',
    'cliente',
    'telefono',
    'email',
    'user_id'
   ];

   public function usuarios():BelongsTo{
      return $this->belongsTo(User::class,'user_id');
   }
}
