<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesorActividadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\UsuarioController;

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

//ruta post que asigna actividad a un profesor
Route::post('/asignarProfesorActividad', [ProfesorActividadController::class, 'asignarProfesorActividad'])->middleware('auth:sanctum', 'verificarRol:admin, profesor');
Route::post('/login', [LoginController::class, 'authAdmin'])->name('login.auth');
Route::middleware('auth:sanctum', 'verificarRol:admin')->get('/actividades', [ActividadController::class, 'mostrarActividades']);
Route::middleware('auth:sanctum', 'verificarRol:admin,profesor')->post('/agregarActividad', [ActividadController::class, 'agregarActividad']);
Route::middleware('auth:sanctum', 'verificarRol:admin,profesor')->post('/editarActividad', [ActividadController::class, 'editarActividad']);
Route::middleware('auth:sanctum', 'verificarRol:admin,profesor')->post('/eliminarActividad', [ActividadController::class, 'eliminarActividad']);
//usuarios
Route::middleware('auth:sanctum', 'verificarRol:admin')->post('/agregarUsuario', [UsuarioController::class, 'agregarUsuario']);
Route::middleware('auth:sanctum', 'verificarRol:admin')->post('/editarUsuario', [UsuarioController::class, 'editarUsuario']);
Route::middleware('auth:sanctum', 'verificarRol:admin')->post('/eliminarUsuario', [UsuarioController::class, 'eliminarUsuario']);
Route::middleware('auth:sanctum', 'verificarRol:admin')->post('/permisosUsuario', [UsuarioController::class, 'permisosUsuario']);