<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class suscripcions extends Model
{
    protected $fillable = [
        'cancelado_al_finalizar_periodo',
        'suscripcion_id',
        'fecha_cargo',
        'fecha_creacion',
        'numero_periodo_actual',
        'fecha_fin_periodo',
        'estado',
        'fecha_fin_prueba',
        'cantidad_cargo_predeterminada',
        'id_plan',
        'id_cliente',
        'user_id',
        'card_id',
        'pago_id'
    ];
    public function usuario():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function  pagos() : HasMany {
        return $this->hasMany(pagos::class);

    }

}
