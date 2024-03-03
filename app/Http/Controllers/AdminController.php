<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Usuario;
use \App\Models\Actividad;
use \App\Models\Rol;

class AdminController extends Controller
{
    public function mostrarLogin(){
        return view('auth.admin.login');
    }

    public function mostrarVistaCRUD(Request $request){
    $usuarios = null;

    if ($request->isMethod('get')) { //verificamos que el metodo sea get
        $usuarios = Usuario::leftJoin('model_has_roles', 'usuarios.id', '=', 'model_has_roles.model_id')
            ->select('usuarios.id', 'usuarios.name', 'usuarios.email', 'model_has_roles.role_id')
            ->get();
    } else { // si no
        $opcionMostrar = $request->input('opcionMostrar');
        if ($opcionMostrar == "todos") {
            $usuarios = Usuario::leftJoin('model_has_roles', 'usuarios.id', '=', 'model_has_roles.model_id')
                ->select('usuarios.id', 'usuarios.name', 'usuarios.email', 'model_has_roles.role_id')
                ->get();
        } elseif ($opcionMostrar == "admin") {
            $admin = Rol::where('name', 'admin')->first();
            $usuarios = Usuario::join('model_has_roles', 'usuarios.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.role_id', $admin->id)
                ->select('usuarios.id', 'usuarios.name', 'usuarios.email', 'model_has_roles.role_id')
                ->get();
        } elseif ($opcionMostrar == "profesores") {
            $profesor = Rol::where('name', 'profesor')->first();
            $usuarios = Usuario::join('model_has_roles', 'usuarios.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.role_id', $profesor->id)
                ->select('usuarios.id', 'usuarios.name', 'usuarios.email', 'model_has_roles.role_id')
                ->get();
        }
    }

    
    $roles = Rol::select('name')->get();
    return view('content.admin.index', ['usuarios' => $usuarios, 'roles' => $roles]);
}
}
