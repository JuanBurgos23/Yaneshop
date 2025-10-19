<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Login
Route::get('iniciar-sesion', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('iniciar-sesion', [LoginController::class, 'login']);
Route::post('cerrar-sesion', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');
//User
Route::get('user', [PerfilController::class, 'index'])->name('mostrar_perfil');
Route::post('/user/{id}/update-avatar', [PerfilController::class, 'updateAvatar'])->name('user.updateAvatar');
Route::delete('/user/{id}/delete-avatar', [PerfilController::class, 'deleteAvatar'])->name('user.deleteAvatar');
Route::post('user-perfil', [PerfilController::class, 'perfilUpdate'])->name('user.perfilUpdate');

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
Route::put('/categorias/{id}/eliminar', [CategoriaController::class, 'eliminarCategoria'])->name('categoria.eliminar');

//sub Categoria
Route::post('/subcategoria-register', [CategoriaController::class, 'storeSubCategoria'])->name('subcategoria.store');
Route::get('/subcategoria/edit/{id}', [CategoriaController::class, 'editSubCategoria'])->name('subcategoria.edit');
Route::put('/subcategoria-update/{id}', [CategoriaController::class, 'updateSubCategoria'])->name('subcategoria.update');
Route::get('/subcategorias/por-categoria', [CategoriaController::class, 'porCategoria'])->name('subcategorias.porCategoria');
Route::get('/subcategorias/{id}', [CategoriaController::class, 'subcategoriasPorCategoria']);
Route::put('/subcategorias/{id}/eliminar', [CategoriaController::class, 'eliminarSubCategoria'])->name('subcategoria.eliminar');

//Producto
Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::post('/producto-register', [ProductoController::class, 'store'])->name('producto.store');
Route::get('/producto/edit/{id}', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('/producto-update/{id}', [ProductoController::class, 'update'])->name('producto.update');
Route::get('/productos/exportar', [ProductoController::class, 'exportar'])->name('productos.exportar');
Route::delete('/producto/imagen/{id}', [ProductoController::class, 'eliminarImagen']);


//consultar si existe el cliente por ci para el formulario
Route::get('/clientes/buscar-telefono/{ci}', [ClienteController::class, 'buscarPorTelefono']);
//registro del cliente
Route::post('/clientes/registrar', [ClienteController::class, 'registrar']);


//registrar empresa
Route::get('/empresa', [EmpresaController::class, 'index'])->name('empresa.index');
Route::post('/empresa', [EmpresaController::class, 'store'])->name('empresa.store');
Route::get('/empresa/{id}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');
Route::put('/empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');

Route::prefix('ajax')->group(function () {
    Route::get('/load-more-promociones', [ProductoController::class, 'loadMorePromociones'])->name('ajax.loadMorePromociones');
    Route::get('/load-more-nuevos', [ProductoController::class, 'loadMoreNuevos'])->name('ajax.loadMoreNuevos');
    Route::get('/load-more-productos', [ProductoController::class, 'loadMoreProductos'])->name('ajax.loadMoreProductos');
});

//rutas para ver usuarioo desde el admin
Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
Route::get('/admin/usuarios/buscar', [UserController::class, 'buscar'])->name('admin.usuarios.buscar');
Route::post('/admin/usuarios/{id}/empresa', [UserController::class, 'crearEmpresa'])->name('admin.usuarios.crearEmpresa');
Route::post('/admin/usuarios/crear', [UserController::class, 'crearUsuario'])->name('admin.usuarios.crear');


Route::get('/{slug}', [ProductoController::class, 'productoInicio'])->name('empresa.public');


//Route::get('/{slug}/comprar', [ProductoController::class, 'productoInicio'])->name('comprar.public');
