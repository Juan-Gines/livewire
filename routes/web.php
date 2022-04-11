<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowPosts;//importamos el componente para usarlo de controlador
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
    return view('welcome');
});

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */

//Modificamos para que use el componente de controlador

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', ShowPosts::class)->name('dashboard');
});


//estamos pasando a esta ruta info que vamos a rescatar en el componente que estamos usando de controller ShowPosts
Route::get('prueba/{name}',ShowPosts::class);