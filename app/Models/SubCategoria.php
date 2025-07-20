<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    protected $table = 'sub_categoria'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'nombre',
        'id_categoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_subcategoria');
    }
}
