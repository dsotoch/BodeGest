<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmacions extends Model
{
    protected $fillable = ['email', 'token'];
}
