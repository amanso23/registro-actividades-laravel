<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfesorActividadController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\GrupoActividadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/login', [AdminController::class, 'mostrarLogin'])->name('login'); //vista del login del admin
Route::post('/login/auth', [LoginController::class, 'authAdmin'])->name('login.auth'); //ruta de autentificacion del admin
Route::get('/admin/CRUD', [AdminController::class, 'mostrarVistaCRUD'])->name('admin.CRUD')->middleware('verificarRol:admin'); //vista del CRUD del admin
Route::post('/admin/CRUD', [AdminController::class, 'mostrarVistaCRUD'])->name('admin.CRUD.post')->middleware('verificarRol:admin');
Route::get('/profesor/CRUD', [ProfesorController::class, 'mostrarVistaCRUD'])->name('profesor.CRUD')->middleware('verificarRol:admin,profesor'); //vista del CRUD del profesor
Route::post('/editar/actividad', [ActividadController::class, 'editarActividad'])->name('editar.actividad')->middleware('verificarRol:admin,profesor'); //ruta que se usa para editar una actividad
Route::post('/agregar/actividad', [ActividadController::class, 'agregarActividad'])->name('agregar.actividad')->middleware('verificarRol:admin,profesor'); //ruta que se utilixa para agregra una activdad nueva
Route::post('/eliminar/actividad', [ActividadController::class, 'eliminarActividad'])->name('eliminar.actividad')->middleware('verificarRol:admin,profesor'); //ruta que se utilixa para eliminar una activdad 
Route::post('/profesor/asignar', [ProfesorActividadController::class, 'asignarProfesorActividad'])->name('profesor.asignar')->middleware('verificarRol:admin,profesor'); //ruta que asigna un profesor a una actividad, en base al id de la actividad
Route::post('/profesor/desasignar', [ProfesorActividadController::class, 'desasignarProfesorActividad'])->name('profesor.desasignar')->middleware('verificarRol:admin,profesor'); //ruta que desasigna a un profesor d una actividad
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('verificarRol:admin,profesor'); //ruta para cerrar sesion
Route::post('/agregar/usuario', [UsuarioController::class, 'agregarUsuario'])->name('agregar.usuario')->middleware('verificarRol:admin');
Route::post('/editar/usuario', [UsuarioController::class, 'editarUsuario'])->name('editar.usuario')->middleware('verificarRol:admin');
Route::post('/eliminar/usuario', [UsuarioController::class, 'eliminarUsuario'])->name('eliminar.usuario')->middleware('verificarRol:admin');
Route::post('/permisos/usuario', [UsuarioController::class, 'permisosUsuario'])->name('permisos.usuario')->middleware('verificarRol:admin');
Route::post('/grupo/asignar', [GrupoActividadController::class, 'asignarGrupoActividad'])->name('grupo.asignar')->middleware('verificarRol:admin,profesor');
Route::post('/grupo/desasignar', [GrupoActividadController::class, 'desasignarGrupoActividad'])->name('grupo.desasignar')->middleware('verificarRol:admin,profesor'); //ruta que desasigna a un profesor d una actividad
*/