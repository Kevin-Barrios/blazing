<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUsuariosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\RecuperarContrasenaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\HistorialComprasController;
use App\Http\Controllers\EditarUsuarioController;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\MetodoPagoController;


Route::resource('compras', CompraController::class)->middleware('auth');

// Rutas públicas (sin sesión)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect('/login'); 
});

Route::get('registro', [RegistroController::class, 'crear'])->name('registro.crear');
Route::post('registro', [RegistroController::class, 'guardar'])->name('registro.guardar');

Route::get('/catalogo', [CatalogoController::class, 'index']);

// Ruta de recuperación de contraseña (comentada por ahora)
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/guardar-compra', [CompraController::class, 'store'])->name('compras.store');
Route::get('/admin/registrar-compra', [CompraController::class, 'crear'])->name('compras.crear');
Route::get('/admin/historial-compras', [HistorialComprasController::class, 'index'])->name('admin.historial');

Route::get('/admin/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/admin/productos/crear', [ProductoController::class, 'create'])->name('productos.crear');
Route::post('/admin/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/admin/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.editar');
Route::put('/admin/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/admin/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
Route::get('/admin/exportar-productos', function () {return Excel::download(new ProductosExport, 'productos.xlsx');})->name('admin.exportar.productos');


Route::get('/admin/usuarios', [AdminUsuariosController::class, 'index'])->name('usuarios.index');
Route::get('/admin/usuarios/crear', [AdminUsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/admin/usuarios', [AdminUsuariosController::class, 'store'])->name('usuarios.store');
Route::get('/admin/usuarios/{id}/editar', [AdminUsuariosController::class, 'edit'])->name('usuarios.edit');
Route::put('/admin/usuarios/{id}', [AdminUsuariosController::class, 'update'])->name('usuarios.update');
Route::delete('/admin/usuarios/{id}', [AdminUsuariosController::class, 'destroy'])->name('usuarios.destroy');


// Rutas protegidas (requieren sesión)
Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
    
    Route::get('/perfil', [EditarUsuarioController::class, 'editar'])->name('usuario.perfil');
    Route::put('/perfil', [EditarUsuarioController::class, 'actualizar'])->name('usuario.perfil.actualizar');

    Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito');
    Route::get('/pago', [PagoController::class, 'mostrarFormulario'])->name('Pago.MostrarFormulario');
    Route::post('/pago/procesar', [PagoController::class, 'procesarPago'])->name('Pago.ProcesarPago');
});



Route::get('/', function () {
    return view('home');
});


Route::view('/hombre', 'categorias.hombre')->name('categorias.hombre');
Route::view('/mujer', 'categorias.mujer')->name('categorias.mujer');
Route::view('/nino', 'categorias.nino')->name('categorias.nino');
Route::view('/novedades', 'categorias.novedades')->name('categorias.novedades');

Route::resource('metodos-pago', MetodoPagoController::class)->middleware('auth');

// Paso 1: desde el carrito (POST con datos)
Route::post('/seleccionar-metodo', [CompraController::class, 'guardarCarritoEnSesion'])
    ->name('seleccionar-metodo.post')
    ->middleware('auth');

// Paso 2: ver la página de selección (GET)
Route::get('/seleccionar-metodo', [CompraController::class, 'seleccionarMetodo'])
    ->name('seleccionar-metodo')
    ->middleware('auth');

// Finalizar compra
Route::post('/finalizar-compra', [CompraController::class, 'finalizarCompra'])
    ->name('finalizar-compra')
    ->middleware('auth');
