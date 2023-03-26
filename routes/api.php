<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\Postcontroller;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout', [AuthController::class, 'logout']);

    //Route::get('categorias',[CategoriaController::class, 'index']);
    //Route::post('categorias',[CategoriaController::class, 'store']);
    //Route::put('categorias',[CategoriaController::class, 'update']);
    
    Route::post('/categorias','App\Http\Controllers\CategoriaController@store');
    Route::get('/categorias','App\Http\Controllers\CategoriaController@index');
    Route::get('/categorias/{categoria}','App\Http\Controllers\CategoriaController@show');
    Route::put('/categorias/{categoria}','App\Http\Controllers\CategoriaController@update');
    Route::delete('/categorias/{categoria}','App\Http\Controllers\CategoriaController@destroy');


    //Route::get('posts',[PostController::class, 'index']);
    
    Route::post('/posts','App\Http\Controllers\PostController@store');
    Route::get('/posts','App\Http\Controllers\PostController@index');
    Route::get('/posts/{post}','App\Http\Controllers\PostController@show');
    Route::put('/posts/{post}','App\Http\Controllers\PostController@update');
    Route::delete('/posts/{post}','App\Http\Controllers\PostController@destroy');


});
