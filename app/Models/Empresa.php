<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $dates = ['fecha_inicio_suscripcion', 'fecha_fin_suscripcion'];
    protected $fillable = [
        'id_user',
        'nombre',
        'telefono_whatsapp',
        'logo',
        'direccion',
        'slug',
        'fecha_inicio_suscripcion',
        'fecha_fin_suscripcion',
        'tipo_suscripcion',
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
    public function isSuscripcionVigente()
    {
        if (!$this->fecha_fin_suscripcion) return false;
        return now()->lte($this->fecha_fin_suscripcion);
    }
}
