<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $fillable = ['nombre', 'descripcion','id_empresa','estado'];


    // Categoria.php
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }

    public function subCategorias()
    {
        return $this->hasMany(SubCategoria::class, 'id_categoria');
    }
}
