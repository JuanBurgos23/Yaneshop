<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable = [
        'id_user',
        'nombre',
        'telefono_whatsapp',
        'logo',
        'direccion',
        'slug'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($empresa) {
            $empresa->slug = Str::slug($empresa->nombre);
        });

        static::updating(function ($empresa) {
            $empresa->slug = Str::slug($empresa->nombre);
        });
    }
}
