<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\Marcacontroller;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\PresController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('templates.template');
});
Route::get('/login', function () {
    return view('auth.login');
});
//routes vistas
Route::view('/panel', 'panel.index')->name('panel');
//Route::view('/categorias', 'categorias.index')->name('categoria');

//routas para categorias => php artisan route:list
Route::resources([
    'categorias' => CategoriaController::class,
    'marcas' => MarcaController::class,
    'presentacion' => PresentacionController::class,
    'productos' => ProductoController::class
]);

//pagina errors
Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});

