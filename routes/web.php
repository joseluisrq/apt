<?php

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
//middelware usuarios invitados
Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@mostrarFormularioLogin'); 
    Route::post('/login','Auth\LoginController@login')->name('login'); 
});

//usuarios autentificados
Route::group(['middleware'=>['auth']],function(){
        //cerrar sesion
        Route::post('/cerrarsesion','Auth\LoginController@cerrarSesion')->name('cerrarsesion'); 
         //Vista principal
        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');

        Route::group(['middleware'=>['Cajero']],function(){
        });

        Route::group(['middleware'=>['Analista']],function(){
                //rutas  cliente
                Route::get('/cliente', 'ClienteController@index');
                Route::post('/cliente/registrar', 'ClienteController@store');
                Route::put('/cliente/actualizar', 'ClienteController@update');

              //Credito
              Route::get('/credito', 'CreditoController@index');
              Route::get('/credito/obtenerCabecera', 'CreditoController@obtenerCabecera');
              Route::get('/credito/obtenerCuotas', 'CreditoController@obtenerCuotas');
              Route::post('/credito/registrar', 'CreditoController@store');
              Route::put('/credito/desactivar', 'CreditoController@desactivar');

        });

        Route::group(['middleware'=>['Administrador']],function(){

            //Clientes
            Route::get('/cliente', 'ClienteController@index');
            Route::post('/cliente/registrar', 'ClienteController@store');
            Route::put('/cliente/actualizar', 'ClienteController@update');


            //usuarios
            Route::get('/user','UserController@index'); 
            Route::post('/user/registrar','UserController@store'); 
            Route::put('/user/actualizar','UserController@update'); 
            Route::put('/user/desactivar','UserController@desactivar'); 
            Route::put('/user/activar','UserController@activar'); 


            //rutas de roles
            Route::get('/rol', 'RolController@index');
            Route::get('/rol/selectRol', 'RolController@selectRol');

            //Credito
            Route::get('/credito', 'CreditoController@index');
            Route::get('/credito/obtenerCabecera', 'CreditoController@obtenerCabecera');
            Route::get('/credito/obtenerCuotas', 'CreditoController@obtenerCuotas');
            Route::post('/credito/registrar', 'CreditoController@store');
            Route::put('/credito/desactivar', 'CreditoController@desactivar');
        });

      
});
 

//Route::get('/home', 'HomeController@index')->name('home');
