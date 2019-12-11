<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/libros/nuevo','LibroController@agregarLibro');
Route::put('/libros/{id}/editar','LibroController@editarLibro');
Route::delete('/libros/{id}/borrar','LibroController@borrarLibro');

Route::get('/libros/autor/{autor}','LibroController@listarAutor');
Route::get('/libros/genero/{genero}','LibroController@listarGenero');


Route::post('/prestamo/prestar','PrestamoController@prestarLibro');
Route::put('/prestamo/{id}/devolver','PrestamoController@devolverLibro');