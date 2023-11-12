<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movimientos extends Model
{
   protected $fillable=['monto','tipo','fecha','operacion','user_id','dinerocaja'];
}
