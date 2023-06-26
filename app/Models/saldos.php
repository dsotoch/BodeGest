<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class saldos extends Model
{
    protected $fillable = [
        "monto_deuda",
        "monto_recibido",
        "monto_restante",
        "fecha",
        "estado",
        "user_id",
        "cliente_id",

    ];
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(clientes::class, 'cliente_id');
    }
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
