<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ventas extends Model
{
    protected $fillable = [
        'documento',
        'estado',
        'fecha',
        'iva',
        'nota',
        'formaPago',
        'montoInicio',
        'totalVenta',
        'moneda',
        'cliente_id',
        'user_id'
    ];
    public function articulos(): BelongsToMany
    {
        return $this->belongsToMany(articulos::class, 'articulos_ventas')
            ->withPivot('cantidad');
    }
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(clientes::class, 'cliente_id');
    }
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
