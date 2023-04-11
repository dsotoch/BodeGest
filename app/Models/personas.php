<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class personas extends Model
{
    protected $fillable = [
        'apellidos',
        'telefono',
        'estado',
        'user_id'
    ];
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
