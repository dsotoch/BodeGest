<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finanzas extends Model
{
    protected $fillable=[
        'fechaInicio',
        'fechaTermino',
        'periodo',
        'totalCompras',
        'totalVentas',
        'totalBalance',
        'retiro',
        'saldo',
        'user_id'

    ];
}
