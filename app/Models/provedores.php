<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class provedores extends Model
{
    protected $fillable = [
        'nombre',
        'pais',
        'direccion',
        'correo',
        'servicio',
        'telefono',
        'user_id',
    ];

    public function articulos(): HasOne
    {
        return $this->hasOne(articulos::class, 'provedor_id', 'id');
    }
    public function usuarios(): BelongsTo

    {
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function compras(): HasMany
    {
        return  $this->hasMany(compras::class,'provedor_id');
    }
}
