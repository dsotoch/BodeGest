<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class cancelarSuscripcions extends Model
{
    protected $fillable=[
        'suscripcion_id',
        'estado',
        'fecha'
    ];
    public function suscripcions():BelongsTo
    {
        return $this->belongsTo(suscripcions::class);
    }
    
}
