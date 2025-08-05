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
        'id_categoria',
        'id_subcategoria',
        'codigo_barras',
        'estado'
    ];

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
