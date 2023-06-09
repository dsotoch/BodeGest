<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'pass'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function suscripciones():HasMany
    {
        return $this->hasMany(suscripcions::class);
    }
    public function personas(): HasOne
    {
        return $this->hasOne(personas::class, 'user_id', 'id');
    }
    public function articulos(): HasOne
    {
        return $this->hasOne(articulos::class, 'user_id', 'id');
    }
    public function provedores(): HasOne
    {
        return $this->hasOne(provedores::class, 'user_id', 'id');
    }
    public function  compras(): HasMany
    {
        return $this->hasMany(compras::class, 'user_id');
    }
    public function clientes(): HasMany
    {
        return $this->hasMany(clientes::class, 'user_id');
    }
    public function saldos(): HasMany
    {
        return $this->hasMany(saldos::class, 'user_id');
    }
}
