<?php

/** @var \Laravel\Lumen\Routing\router-> $router-> */

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Auth
$router->post('register', 'AuthController@registerUser');
$router->post('login', 'AuthController@login');


$router->group( ['prefix' => 'api'] , function() use($router) {
    //User
    $router->get('masyarakat', 'UserController@index');
    $router->get('masyarakat/{id}', 'UserController@show');
    $router->get('search-masyarakat/{nama}', 'UserController@search');
    $router->post('upload-masyarakat/{id}', 'UserController@upload');
    $router->put('masyarakat/{id}', 'UserController@update');
    $router->delete('masyarakat/{id}', 'UserController@delete');

    //Petugas
    $router->get('petugas', 'PetugasController@index');
    $router->get('petugas/{id}', 'PetugasController@show');
    $router->get('search-petugas/{nama_petugas}', 'PetugasController@search');
    $router->post('upload-petugas/{id}', 'PetugasController@upload');
    $router->post('petugas', 'PetugasController@create');
    $router->put('petugas/{id}', 'PetugasController@update');
    $router->delete('petugas/{id}', 'PetugasController@delete');

    //Pengaduan
    $router->get('pengaduan', 'PengaduanController@index');
    $router->get('pengaduan/{id}', 'PengaduanController@show');
    $router->get('search-pengaduan/{pengaduan}', 'PengaduanController@search');
    $router->post('pengaduan', 'PengaduanController@create');
    $router->post('upload-pengaduan/{id}', 'PengaduanController@upload');
    $router->put('pengaduan/{id}', 'PengaduanController@update');
    $router->delete('pengaduan/{id}', 'PengaduanController@delete');

    //Tanggapan
    $router->get('tanggapan', 'TanggapanController@index');
    $router->get('tanggapan/{id}', 'TanggapanController@show');
    $router->get('search-tanggapan/{tanggapan}', 'TanggapanController@search');
    $router->post('tanggapan', 'TanggapanController@create');
    $router->put('tanggapan/{id}', 'TanggapanController@update');
    $router->delete('tanggapan/{id}', 'TanggapanController@delete');
});





