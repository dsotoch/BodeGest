<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
   public function ventas():HasMany{
      return $this->hasMany(ventas::class,'cliente_id');
   }
   public function saldos():HasMany{
      return $this->hasMany(saldos::class,'cliente_id');
   }
}
