<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;

class ActividadController extends Controller
{

    public function mostrarActividades(){
        $actividades = Actividad::leftJoin('profesores_actividades', 'actividades.id', '=', 'profesores_actividades.actividad_id') //hacemos un leftJoin a la tabla actividades para obtener todas las ctividades, tanto las que tienen asignado profesores como las que no
        ->leftJoin('profesores', 'profesores_actividades.profesor_id', '=', 'profesores.id')
        ->leftJoin('grupos_actividades', 'actividades.id', '=', 'grupos_actividades.actividad_id')
        ->leftJoin('grupos', 'grupos_actividades.grupo_id', '=', 'grupos.id')
        ->leftJoin('usuarios', 'profesores.usuario_id', '=', 'usuarios.id')
        ->select('actividades.id', 'actividades.nombre', 'actividades.descripcion', 'actividades.lugar', 'actividades.fecha', 'actividades.duracion', 'usuarios.name', 'profesores.id as profesor_id', 'grupos.name as nombre_grupo', 'grupos.id as grupo_id')
        ->get();
        return response()->json(['actividades' => $actividades], 200);
    }

    //Controlador que se usara para añadir, editar o eliminar una actividad
    public function agregarActividad(Request $request) {
        try {
            $actividad = new Actividad();
            $actividad->nombre = $request->input('nombreActividad');
            $actividad->descripcion = $request->input('descripcionActividad');
            $actividad->lugar = $request->input('lugarActividad');
            $actividad->fecha = $request->input('fechaActividad');
            $actividad->duracion = $request->input('duracionActividad');
    
            $actividad->save();
            return response()->json(['mensaje' => 'Actividad agregada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => 'Error al agregar la actividad: ' . $e->getMessage()], 500);
        }
    }
    

    public function editarActividad(Request $request){
        //dd($request->input('id_actividad'));
        if($request->input('id_actividad') == null){
            return response()->json(['mensaje' => 'No se ha introducido un id de actividad.'], 500);
        }

        $actividad = Actividad::find($request->input('id_actividad')); //obtenemos la actividad por su id
        if($actividad == null){
            return response()->json(['mensaje' => 'El id introducido no es valido'], 500);
        }
        $camposNulos = 0; //cantidad de campos nulos pasados 

    
        //verificamos si los campos han sido introducidos correctamente, editando solo aquellos que lo cumplan
        if ($request->filled('nombreActividad')) {
            $actividad->nombre = $request->input('nombreActividad');
        }else{
            $camposNulos++;
        }

        if ($request->filled('descripcionActividad')) {
            $actividad->descripcion = $request->input('descripcionActividad');
        }else{
            $camposNulos++;
        }

        if ($request->filled('lugarActividad')) {
            $actividad->lugar = $request->input('lugarActividad');
        }else{
            $camposNulos++;
        }

        if ($request->filled('fechaActividad')) {
            $actividad->fecha = $request->input('fechaActividad');
        }else{
            $camposNulos++;
        }

        if ($request->filled('duracionActividad')) {
            $actividad->duracion = $request->input('duracionActividad');
        }else{
            $camposNulos++;
        }

        if($camposNulos == 5){
            return response()->json(['mensaje', 'No se han modificado datos']);
        }

        try{
            $actividad->save();
            return response()->json(['mensaje' => 'Actividad editada correctamente'], 200);

        }catch(\Exception $e){
            return response()->json(['mensaje' => 'Error al editar la actividad: ' . $e->getMessage()], 500);
        }

    }

    public function eliminarActividad(Request $request){
        if($request->input('actividad_id') == null){
            return response()->json(['mensaje' => 'No se ha introducido un id de actividad.'], 500);
        }

        $actividad = Actividad::find($request->input('actividad_id'));

        if($actividad == null){
            return response()->json(['mensaje' => 'El id introducido no es valido'], 500);
        }

        try{
            $actividad->delete();
            return response()->json(['mensaje' => 'Actividad eliminada correctamente'], 200);

        }catch(\Exception $e){
            return response()->json(['mensaje' => 'Error al eliminar la actividad: ' . $e->getMessage()], 500);

        }
        
    }
}
