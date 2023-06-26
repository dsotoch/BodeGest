<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas extends Model
{
    protected $fillable=[
        'ruc',
        'nombre',
        'telefono',
        'direccion',
        'user_id'
    ];
}
