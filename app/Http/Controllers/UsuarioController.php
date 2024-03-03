<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ModelHasRol;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Profesor;

class UsuarioController extends Controller
{
    public function agregarUsuario(Request $request){
        $usuario = new Usuario();
        $usuario->name = $request->input('nombreUsuario');
        $usuario->email = $request->input('emailUsuario');
        $usuario->password = Hash::make($request->input('passwordUsuario'));
        
        
        if($request->input('rol') == 'admin'){
            $usuario->rol = 'admin';
            $usuario->assignRole('admin'); 
            $usuario->save();
            return response()->json(['mensaje' => 'Se ha guardado al admin ' . $request->input('nombreUsuario') . ' con permisos de admin']);

        }elseif($request->input('rol') == 'profesor'){
            $usuario->rol = 'profesor';
            if ($usuario->save()) {
                $profesor = new Profesor();
                $profesor->usuario_id = $usuario->id;

                if ($profesor->save()) {
                    $usuario->assignRole('profesor');
                    return response()->json(['mensaje' => 'Se ha guardado al profesor ' . $request->input('nombreUsuario') . ' con permisos de profesor']);
                }
            }
        }

        return response()->json(['error' => 'Error al guardar al usuario'], 500);
    }

    public function editarUsuario(Request $request){
        $usuario = Usuario::find($request->input('usuario_id'));
        $passworModificada = false;
        $camposNulos = 0;

        if($request->filled('nombreUsuario')){
            $usuario->name = $request->input('nombreUsuario');
        }else{
            $camposNulos++;
        }
        if($request->filled('emailUsuario')){
            $usuario->email = $request->input('emailUsuario');
        }else{
            $camposNulos++;
        }
        if($request->filled('passwordUSuario')){
            $usuario->password = Hash::make($request->input('passwordUsuario'));
            $passworModificada = true;
        }else{
            $camposNulos++;
        }

        $usuario->save();

        if($camposNulos == 3){
            return response()->json(['mensaje' => 'No se han modificado datos']);
        }

        if($passworModificada == true){
            return response()->json(['mensaje' => 'La contraseña del usuario ha sido modificada']);
        }

        return response()->json(['mensaje' => 'Usuario editado correctamente']);
    }

    public function eliminarUsuario(Request $request){
        $email = request()->cookie('email');
        $usuarioAux = Usuario::where('email', $email)->first();
        $usuario = Usuario::find($request->input('usuario_id'));
        if($usuario->id == $usuarioAux->id){
            return response()->json(['mensaje' => 'No puedes eliminarte a ti mismo']);
        }
        if($usuario->delete()){
            return response()->json(['mensaje' => "Se ha eliminado a " . $usuario->name . " de la lista de usuarios"]);
        }
        return response()->json(['error' => "Error al eliminar al usuario"], 500);
    }

    public function permisosUsuario(Request $request)
    {
        
        $usuario = Usuario::find($request->input('usuario_id'));
        if ($request->input('permiso') == 'admin') {
            if ($usuario->hasRole('admin')) {
                return response()->json(['mensaje' => "Este usuario ya tiene permisos de administrador"]);
            } else {
                if($usuario->hasRole('profesor')){
                    $role = Role::where('name', 'profesor')->first();
                    DB::table('model_has_roles')->where('role_id', $role->id)->where('model_id', $request->input('usuario_id'))->delete();
                } 
                $usuario->assignRole('admin');
                $usuario->rol = 'admin';
                $usuario->save();
                return response()->json(['mensaje' => "Se le han otorgado permisos de administrador a " . $usuario->name]);
            }
        } elseif ($request->input('permiso') == 'profesor') {
            if ($usuario->hasRole('profesor')) {
                return response()->json(['mensaje' => "Este usuario ya tiene permisos de profesor"]);
            } else {
                if($usuario->hasRole('admin')){
                    $role = Role::where('name', 'admin')->first();
                    DB::table('model_has_roles')->where('role_id', $role->id)->where('model_id', $request->input('usuario_id'))->delete();
                }
                $usuario->assignRole('profesor');
                $usuario->rol = 'profesor';
                $usuario->save();
                return response()->json(['mensaje' => "Se le han otorgado permisos de profesor a " . $usuario->name]);
            }
        }
        return response()->json(['error' => "Error al otorgar permisos"], 500);
    }
    
    

}
