<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class provedores extends Model
{
    protected $fillable = [
        'nombre',
        'documento',
        'direccion',
        'correo',
        'telefono',
    ];

    public function articulos(): BelongsTo
    {
        return $this->belongsTo(articulos::class, 'id_provedor', 'id');
    }
}
