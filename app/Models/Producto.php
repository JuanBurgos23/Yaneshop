<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'precio_oferta',
        'oferta_tipo',
        'precio_oferta_tipo',
        'id_categoria',
        'id_subcategoria',
        'codigo_barras',
        'estado',
        'id_empresa'
    ];
    // 👇 Estos atributos se agregan automáticamente al serializar a JSON
    protected $appends = ['oferta_tipo_formateado', 'precio_oferta_tipo_valor'];

    // Accessor para mostrar oferta_tipo
    public function getOfertaTipoFormateadoAttribute()
    {
        return $this->oferta_tipo; // ya viene de la DB
    }

    // Accessor para mostrar precio_oferta_tipo
    public function getPrecioOfertaTipoValorAttribute()
    {
        return $this->precio_oferta_tipo; // ya viene de la DB
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    public function subcategoria()
    {
        return $this->belongsTo(SubCategoria::class, 'id_subcategoria');
    }
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'id_producto');
    }
}
