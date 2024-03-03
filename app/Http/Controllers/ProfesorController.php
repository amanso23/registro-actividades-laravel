<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profesor;
use App\Models\Usuario;
use App\Models\Actividad;
use App\Models\ModelHasRol;
use App\Models\Grupo;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;



class ProfesorController extends Controller
{
    public function mostrarLogin(){
        return view('auth.profesor.login');
    }
    public function mostrarVistaCRUD(){
        $grupos = Grupo::all();
        $profesores = Profesor::join('usuarios', 'profesores.usuario_id', '=', 'usuarios.id')->select('profesores.id', 'usuarios.name')->get(); //obtenemos de la lista de usuarios a los que tienen el rol de profesor
        $actividades = Actividad::leftJoin('profesores_actividades', 'actividades.id', '=', 'profesores_actividades.actividad_id') //hacemos un leftJoin a la tabla actividades para obtener todas las ctividades, tanto las que tienen asignado profesores como las que no
        ->leftJoin('profesores', 'profesores_actividades.profesor_id', '=', 'profesores.id')
        ->leftJoin('grupos_actividades', 'actividades.id', '=', 'grupos_actividades.actividad_id')
        ->leftJoin('grupos', 'grupos_actividades.grupo_id', '=', 'grupos.id')
        ->leftJoin('usuarios', 'profesores.usuario_id', '=', 'usuarios.id')
        ->select('actividades.id', 'actividades.nombre', 'actividades.descripcion', 'actividades.lugar', 'actividades.fecha', 'actividades.duracion', 'usuarios.name', 'profesores.id as profesor_id', 'grupos.name as nombre_grupo', 'grupos.id as grupo_id')
        ->get();
        return view('content.profesor.index', ['profesores' => $profesores, 'actividades' => $actividades, 'grupos' => $grupos]);
    }
}
