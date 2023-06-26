<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pagos extends Model
{
    protected $fillable = [
        'monto',
        'descripcion',
        'suscripcion_id',

    ];
    public function suscripcions():BelongsTo
    {
        return $this->belongsTo(suscripcions::class);
    }

   
}
