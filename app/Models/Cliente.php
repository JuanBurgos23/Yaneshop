<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = "cliente";

    protected $fillable = [
        "id",
        "nombre",
        "paterno",
        "materno",
        "ci",
        "telefono",
        "correo",


    ];

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->paterno} {$this->materno}";
    }
}
