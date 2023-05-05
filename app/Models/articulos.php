<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'provedor_id',
        'user_id',
        'compra_id',
        'estado',
    ];
    public function provedores(): BelongsTo
    {
        return $this->belongsTo(provedores::class, 'provedor_id');
    }
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function compras(): BelongsTo
    {
        return $this->belongsTo(compras::class, 'compra_id');
    }
    public function ventas(): BelongsToMany
    {
        return $this->belongsToMany(ventas::class, 'articulo_ventas')
            ->withPivot('cantidad');
    }
}
