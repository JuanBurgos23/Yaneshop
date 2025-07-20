<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $table = 'categoria';
    protected $fillable = ['nombre', 'descripcion'];


    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function subCategorias()
    {
        return $this->hasMany(SubCategoria::class, 'id_categoria');
    }
}
