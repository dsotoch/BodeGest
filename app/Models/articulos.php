<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class articulos extends Model
{
    protected $fillable = [
        'descripcion',
        'marca',
        'presentacion',
        'stock',
        'precioCompra',
        'precioVenta',
        'medida',
        'lucro',
        'id_provedor'
    ];
    public function provedores(): HasOne
    {
        return $this->hasOne(provedores::class, 'id_provedor', 'id');
    }
}
