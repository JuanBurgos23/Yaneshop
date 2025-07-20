<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//User
Route::get('user', [PerfilController::class, 'index'])->name('mostrar_perfil');
Route::post('/user/{id}/update-avatar', [PerfilController::class, 'updateAvatar'])->name('user.updateAvatar');
Route::delete('/user/{id}/delete-avatar', [PerfilController::class, 'deleteAvatar'])->name('user.deleteAvatar');
Route::post('user-perfil', [PerfilController::class, 'perfilUpdate'])->name('user.perfilUpdate');

Route::get('/producto', [ProductoController::class, 'indexWelcome'])->name('product.index');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
//Cliente
Route::get('cliente', [ClienteController::class, 'index'])->name('mostrar_cliente');
Route::post('/cliente-register', [ClienteController::class, 'store']);
Route::get('/cliente/edit/{id}', [ClienteController::class, 'edit']);
Route::put('/cliente-update/{id}', [ClienteController::class, 'update']);
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
//Categoría
Route::get('/categoria', [CategoriaController::class, 'index'])->name('mostrar_categoria');
Route::get('/categorias/buscar', [CategoriaController::class, 'buscar'])->name('categorias.buscar');
Route::post('/categoria-register', [CategoriaController::class, 'store'])->name('categoria.store');
Route::get('/categoria/edit/{id}', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::put('/categoria-update/{id}', [CategoriaController::class, 'update'])->name('categoria.update');
//sub Categoria
Route::post('/subcategoria-register', [CategoriaController::class, 'storeSubCategoria'])->name('subcategoria.store');
Route::get('/subcategoria/edit/{id}', [CategoriaController::class, 'editSubCategoria'])->name('subcategoria.edit');
Route::put('/subcategoria-update/{id}', [CategoriaController::class, 'updateSubCategoria'])->name('subcategoria.update');
Route::get('/subcategorias/por-categoria', [CategoriaController::class, 'porCategoria'])->name('subcategorias.porCategoria');
Route::get('/subcategorias/{id}', [CategoriaController::class, 'subcategoriasPorCategoria']);

//Producto

Route::post('/producto-register', [ProductoController::class, 'store'])->name('producto.store');
Route::get('/producto/edit/{id}', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('/producto-update/{id}', [ProductoController::class, 'update'])->name('producto.update');
Route::get('/productos/exportar', [ProductoController::class, 'exportar'])->name('productos.exportar');
Route::delete('/producto/imagen/{id}', [ProductoController::class, 'eliminarImagen']);
