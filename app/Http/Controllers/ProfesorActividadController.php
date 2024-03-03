<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfesorActividad;
use App\Models\Profesor;
use App\Models\Actividad;


class ProfesorActividadController extends Controller
{
    public function asignarProfesorActividad(Request $request) {
        $actividadId = $request->input('id_actividad'); // obtenemos el id de la actividad
        $profesorId = $request->input('profesor_id'); // obtenemos el id del profesor
    
        // Verificamos si tanto la actividad como el profesor existen
        $actividad = Actividad::find($actividadId);
        $profesor = Profesor::find($profesorId);
    
        if (!$actividad || !$profesor) {
            return response()->json(['status' => 'error', 'message' => 'La actividad o el profesor no existen'], 400);
        }
    
        // Verificamos si el profesor ya ha sido asignado a la actividad
        $yaAsignado = ProfesorActividad::where('actividad_id', $actividadId)
                                        ->where('profesor_id', $profesorId)
                                        ->exists();
    
        if ($yaAsignado) {
            return response()->json(['status' => 'error', 'message' => 'El profesor ya ha sido asignado a esta actividad'], 400);
        }
    
        // Asignamos el profesor a la actividad
        $profesorActividad = new ProfesorActividad();
        $profesorActividad->actividad_id = $actividadId;
        $profesorActividad->profesor_id = $profesorId;
        $profesorActividad->save();
    
        return response()->json(['status' => 'success', 'message' => 'El profesor ha sido asignado a la actividad'], 200);
    }
    
    /*
    public function desasignarProfesorActividad(Request $request){
        $profesorActividad = ProfesorActividad::where('profesor_id', $request->input('profesor_id'))
        ->where('actividad_id', $request->input('actividad_id'))
        ->first(); //obtnemos la instancia del modelo que cumpla dicha condicion
       
        $profesorActividad->delete(); // lo eliminamos
        return redirect('/profesor/CRUD');

    }
    */

}
