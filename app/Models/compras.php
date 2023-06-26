<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class compras extends Model
{
    protected $fillable = [
        'metodoPago',
        'totalCompra',
        'user_id',
        'provedor',
        'fecha',
        'public_path',
        'comprobante',
    ];

    public function articulos():HasMany{
        return $this->hasMany(articulos::class,'compra_id');
    }
    public function provedores():BelongsTo{
        return $this->belongsTo(provedores::class,'provedor_id');
    }
    public function usuarios():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }
}
