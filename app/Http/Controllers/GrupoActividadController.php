<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrupoActividad;

class GrupoActividadController extends Controller
{
    public function asignarGrupoActividad(Request $request){
        $actividadId = $request->input('id_actividad'); //obtenemos el id de la actividad
        $grupoId = $request->input('grupo_id'); //obtenemos el id del profesor

        $yaAsignado = GrupoActividad::where('actividad_id', $actividadId) //verificamos ei el profesor ya ha sido asignado a la actividad
                                    ->where('grupo_id', $grupoId)
                                    ->exists();

        if($yaAsignado){ //si ya ha sido asignado, redireccionamos a la vista del crud del profesor con un mensaje
            return redirect('/profesor/CRUD')->with('mensaje-info', 'El grupo ya ha sido asignado a esta actividad');
        }else{ //si no 
            $grupoActividad = new GrupoActividad(); //creamos una instacoa de modelo 
            $grupoActividad->actividad_id = $actividadId; //asiganmos el id del grupo con una actividda
            $grupoActividad->grupo_id = $grupoId;
            $grupoActividad->save(); //guardamos los cambios
            return redirect('/profesor/CRUD');
        }
    }

    public function desasignarGrupoActividad(Request $request){
        $grupoActividad = GrupoActividad::where('grupo_id', $request->input('grupo_id'))
        ->where('actividad_id', $request->input('actividad_id'))
        ->first(); //obtnemos la instancia del modelo que cumpla dicha condicion
       
        $grupoActividad->delete(); // lo eliminamos
        return redirect('/profesor/CRUD');

    }



}
