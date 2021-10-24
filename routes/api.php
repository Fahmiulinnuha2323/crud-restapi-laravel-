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


Route::get('/produk','ApiProdukController@index');

Route::get('/produk/kategori/{id}','ApiProdukController@showByKategori');
Route::get('/produk/nama/{nama} ','ApiProdukController@showByNama');
Route::get('/produk/{id}','ApiProdukController@showById');

Route::delete('/produk/{id}','ApiProdukController@destroy');

Route::get('/kategori','ApiKategoriProdukController@index');
Route::post('/kategori','ApiKategoriProdukController@store');
Route::get('/kategori/{id}','ApiKategoriProdukController@show');
Route::put('/kategori/{id}','ApiKategoriProdukController@update');
Route::delete('/kategori/{id}','ApiKategoriProdukController@destroy');
