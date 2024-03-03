<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        .s{
            cursor: pointer;
        }

        .s:hover{
            transform: scale(1.05);
        }

        .card{
            min-width: 430px;
            max-width: 430px;
            margin: auto
        }
        
    </style>
</head>



<body>
    @if (session('info'))
        <div class="alert alert-info"> {{ session('info') }} </div>
    @endif
    @if(session('mensaje-info'))
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 123, 255, 0.8); z-index: 100; color: #fff;">
            <div>
                <div class="d-flex align-items-center">
                    <p class="fs-4">{{ session('mensaje-info') }}</p>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 10px; right: 10px; color: #fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="container-fluid row mt-4 mb-4 m-auto">
        <div class="col-md-12">
            <div class="alert alert-info " role="alert">
                <div class="mensaje-bienvenida d-flex align-items-center">
                    @php
                        $email = request()->cookie('email');
                    @endphp
                    @if($email)
                        <div class="bienvenida">
                            <h4 class="alert-heading"><i class="fas fa-user-circle"></i> Bienvenido {{ $email }}</h4>
                        </div>
                        <div class="" style="opacity: 0">.....</div>
                        <div class="logout">
                            <a href="{{route('logout')}}" class="btn btn-primary">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    @endif
                </div>
            
                <p>
                    Administra tus actividades en esta sección. Al presionar "Asignar", puedes asignar profesores <i class="fas fa-chalkboard-teacher"></i> a la actividad, realizar ediciones o eliminar la actividad seleccionada. También puedes crear una nueva actividad haciendo clic en "Añadir actividad" <i class="fas fa-plus"></i>.
                    Las actividades que no tengan profesores asignados se marcarán en amarillo en su sección correspondiente <i class="fas fa-exclamation-triangle"></i>, y en verde si tienen al menos uno asignado <i class="fas fa-check"></i>, exactamente igual que los grupos <i class="fas fa-users"></i>. Puedes eliminar grupos y profesores clicando encima de ellos <i class="fas fa-trash-alt"></i>.
                </p>
                
                
                
                <hr>
                <div class="card-footer text-center"> <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#agregarActividadModal"><i class="fas fa-plus"></i> Añadir actividad</a> </div>
            </div>

            @if (isset($actividades) && count($actividades) != 0)
                <div class="row row-cols-1 row-cols-xl-3 g-4">
                    @foreach ($actividades->groupBy('id') as $id => $actividad) <!--Agrupamos las actividades por su id -->
                        <div class="col">
                            <div class="card h-100 w-100">
                                <div class="card-header text-center bg-primary text-white">
                                    <h5 class="m-0"><i class="fas fa-calendar-alt"></i>
                                        {{ $actividad[0]->nombre }}</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item fs-5"><i class="fas fa-map-marker-alt"></i>
                                            <strong>Lugar:</strong> {{ $actividad[0]->lugar }}
                                        </li>
                                        <li class="list-group-item fs-5"><i class="far fa-calendar"></i> <strong>Fecha:</strong>
                                            {{ $actividad[0]->fecha }}
                                        </li>
                                        <li class="list-group-item fs-5"><i class="far fa-clock"></i> <strong>Duración:</strong>
                                            {{ $actividad[0]->duracion }}
                                        </li>
                                        <li class="list-group-item fs-6">
                                            <i class="fas fa-info-circle"></i> {{ $actividad[0]->descripcion }}
                                        </li>
                                    </ul>
                                    </p>
                                    <div class="d-flex flex-wrap">
                                        @php
                                            $profesorSinAsignarMostrado = false;
                                        @endphp

                                        @foreach ($actividad->groupBy('profesor_id') as $id => $profesoresAux)       
                                            @if (!empty($profesoresAux[0]->name))
                                                <p class="badge s bg-success m-1 fs-6 p" data-toggle="modal" data-target="#desasignarProfesorActividad" data-id="{{$profesoresAux[0]->profesor_id}}" name="{{$actividad[0]->id}}">
                                                    <i class="fas fa-chalkboard-teacher"></i> {{ $profesoresAux[0]->name }}
                                                </p>
                                            @else
                                                @if (!$profesorSinAsignarMostrado)
                                                    <p class="badge bg-warning m-1 fs-6">
                                                        <i class="fas fa-exclamation-triangle"></i> Profesor sin asignar
                                                    </p>
                                                    @php
                                                        $profesorSinAsignarMostrado = true;
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="d-flex flex-wrap">

                                        @php
                                            $grupoSinAsignarMostrado = false; 
                                        @endphp

                                        @foreach ($actividad->groupBy('grupo_id') as $id => $grupo)
                                            @if (!empty($grupo[0]->nombre_grupo))
                                                <p class="badge s bg-primary m-1 fs-6 g" data-target="#desasignarGrupoActividad" data-toggle="modal"  data-id="{{$grupo[0]->grupo_id}}" name="{{$actividad[0]->id}}">
                                                    <i class="fas fa-users"></i> {{ $grupo[0]->nombre_grupo }}
                                                </p>
                                            @else
                                                @if (!$grupoSinAsignarMostrado)
                                                    <p class="badge bg-warning m-1 fs-6">
                                                        <i class="fas fa-exclamation-triangle"></i> Grupo sin asignar
                                                    </p>
                                                    @php
                                                        $profesorSinAsignarMostrado = true;
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach
                        
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#" class="btn btn-primary btnAgregar" data-toggle="modal" data-target="#agregarProfesorModal" data-id="{{$actividad[0]->id}}">
                                        <i class="fas fa-user-plus"></i> Asignar
                                    </a>

                                    <a href="#" class="btn btn-success btnAsignar" data-toggle="modal" data-target="#asignarGrupoModal" data-id="{{$actividad[0]->id}}">
                                        <i class="fas fa-plus"></i> Grupo
                                    </a>
                                    
                                    <a href="#" class="btn btn-warning btnEditar" data-toggle="modal" data-target="#editarActividadModal" data-id="{{$actividad[0]->id}}">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="#" class="btn btn-danger btnEliminar" data-toggle="modal" data-target="#borrarActividadModal" data-id="{{$actividad[0]->id}}">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning d-flex flex-column align-items-center" role="alert">
                    <i class="fas fa-info-circle fa-2x g-2"></i>
                    <p>No hay actividades disponibles en este momento.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <a href="{{route('admin.CRUD')}}" class="btn btn-primary mb-4 mt-4">Usuarios <i class="fas fa-arrow-right"></i></a>
    </div>

    <hr>

    <div class="modal fade" id="agregarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="agregarProfesorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarProfesorModalLabel">Asignar Profesor a la Actividad </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <form action="{{route('profesor.asignar')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" id="id-1" name="id_actividad" class="d-none">
                            <label for="profesorSelect" class="mb-2"><span class="badge bg-success">Profesores disponibles</span></label>
                            <select class="form-control" id="profesorSelect" name="profesor_id">
                                @foreach($profesores as $profesor)
                                    <option value="{{$profesor->id}}">{{$profesor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="asignarGrupoModal" tabindex="-1" role="dialog" aria-labelledby="asignarGrupoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignarGrupoModal">Asignar Grupo a la Actividad </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <form action="{{route('grupo.asignar')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" id="id-aux" name="id_actividad" class="d-none">
                            <label for="grupoSelect" class="mb-2"><span class="badge bg-success">Grupos disponibles</span></label>
                            <select class="form-control" id="grupoSelect" name="grupo_id">
                                @foreach($grupos as $grupo)
                                    <option value="{{$grupo->id}}">{{$grupo->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agregarActividadModal" tabindex="-1" role="dialog" aria-labelledby="agregarActividadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarActividadModalLabel">Agregar Actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('agregar.actividad')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreActividad"><i class="fas fa-calendar-alt"></i> Nombre de la Actividad</label>
                            <input type="text" class="form-control" id="nombreActividad" name="nombreActividad" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcionActividad"><i class="fas fa-quote-right"></i> Descripcion de la Actividad</label>
                            <input type="text" class="form-control" id="descripcionActividad" name="descripcionActividad" required>
                        </div>
                        <div class="form-group">
                            <label for="lugarActividad"><i class="fas fa-map-marker-alt"></i> Lugar</label>
                            <input type="text" class="form-control" id="lugarActividad" name="lugarActividad" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaActividad"><i class="far fa-calendar"></i> Fecha</label>
                            <input type="date" class="form-control" id="fechaActividad" name="fechaActividad" required>
                        </div>
                        <div class="form-group">
                            <label for="duracionActividad"><i class="far fa-clock"></i> Duración</label>
                            <input type="datetime" class="form-control" id="duracionActividad" name="duracionActividad" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarActividadModal" tabindex="-1" role="dialog" aria-labelledby="agregarActividadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarActividadModalLabel">Editar Actividad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('editar.actividad')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" id="id-2" name="id_actividad" class="d-none"> <!-- A traves del js le asigno como valor a este input el id de la actividad -->
                        <div class="form-group">
                            <label for="nombreActividad"><i class="fas fa-calendar-alt"></i> Nombre de la Actividad</label>
                            <input type="text" class="form-control" id="nombreActividad" name="nombreActividad">
                        </div>
                        <div class="form-group">
                            <label for="descripcionActividad"><i class="fas fa-quote-right"></i> Descripcion de la Actividad</label>
                            <input type="text" class="form-control" id="descripcionActividad" name="descripcionActividad">
                        </div>
                        <div class="form-group">
                            <label for="lugarActividad"><i class="fas fa-map-marker-alt"></i> Lugar</label>
                            <input type="text" class="form-control" id="lugarActividad" name="lugarActividad">
                        </div>
                        <div class="form-group">
                            <label for="fechaActividad"><i class="far fa-calendar"></i> Fecha</label>
                            <input type="date" class="form-control" id="fechaActividad" name="fechaActividad">
                        </div>
                        <div class="form-group">
                            <label for="duracionActividad"><i class="far fa-clock"></i> Duración</label>
                            <input type="datetime" class="form-control" id="duracionActividad" name="duracionActividad" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="borrarActividadModal" tabindex="-1" role="dialog" aria-labelledby="borrarActividadModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >¿Deseas eliminar la actividad??</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('eliminar.actividad')}}" method="POST">
                    @csrf
                    <div class="alert alert-danger m-1 p-3 text-center"><i class="fas fa-exclamation-triangle"></i> Eliminarás permanentemente la actividad</div>
                    <input type="text" id="id-5" name="actividad_id" class="d-none">
                    <div class="badge bg-success profesor"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="desasignarProfesorActividad" tabindex="-1" role="dialog" aria-labelledby="desasignarProfesorActividad" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >¿Deseas desasignar al profesor de la actividad?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('profesor.desasignar')}}" method="POST">
                    @csrf
                    <div class="alert alert-danger m-1 p-3 text-center"><i class="fas fa-exclamation-triangle"></i> Eliminarás permanentemente al profesor de la actividad</div>
                    <input type="text" id="id-3" name="profesor_id" class="d-none">
                    <input type="text" id="id-4" name="actividad_id" class="d-none">
                    <div class="badge bg-success profesor"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="desasignarGrupoActividad" tabindex="-1" role="dialog" aria-labelledby="desasignarGrupoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >¿Deseas desasignar al grupo de la actividad?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('grupo.desasignar')}}" method="POST">
                    @csrf
                    <div class="alert alert-danger m-1 p-3 text-center"><i class="fas fa-exclamation-triangle"></i> Eliminarás permanentemente al grupo de la actividad</div>
                    <input type="text" id="id-6" name="grupo_id" class="d-none">
                    <input type="text" id="id-7" name="actividad_id"  class="d-none" >
                    <div class="badge bg-success profesor"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    


    <script>
         document.addEventListener('DOMContentLoaded', function () {
            //agregar
            var modalTriggersA = document.querySelectorAll('.btnAgregar'); //obtenemos todos los botones agregar el id de cada activida
            var idInput1 = document.querySelector('#id-1');

            modalTriggersA.forEach(function(trigger) { //a cada modal le pasamos el id de la actividad
                trigger.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    idInput1.value = id;
                });
            });
            //asignar grupos
            var botonesAsignar = document.querySelectorAll('.btnAsignar'); //obtenemos todos los botones agregar el id de cada activida
            var idAux = document.querySelector('#id-aux');

            botonesAsignar.forEach(function(boton) { //a cada modal le pasamos el id de la actividad
                boton.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    idAux.value = id;
                });
            });
            //editar
            var modalTriggersE = document.querySelectorAll('.btnEditar'); //obtenemos todos los botones agregar el id de cada activida
            var idInput2 = document.querySelector('#id-2');

            modalTriggersE.forEach(function(trigger) { //a cada modal le pasamos el id de la actividad
                trigger.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    idInput2.value = id;
                });
            });
            //eliminar
            var modalTriggersEl = document.querySelectorAll('.btnEliminar'); //obtenemos todos los botones agregar el id de cada activida
            var idInput5 = document.querySelector('#id-5');

            modalTriggersEl.forEach(function(trigger) { //a cada modal le pasamos el id de la actividad
                trigger.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    idInput5.value = id;
                });
            });

            //obtner profesores seleccionados
            var profesores = document.querySelectorAll('.p'); //obtenemos todos los botones agregar el id de cada activida
            var idInput3 = document.querySelector('#id-3');
            var idInput4 = document.querySelector('#id-4');

            profesores.forEach(function(profesor) { //a cada modal le pasamos el id de la actividad
                profesor.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var idAux = this.getAttribute('name');
                    idInput3.value = id;
                    idInput4.value = idAux;
                });
            });

            //obtner profesores seleccionados
            var grupos = document.querySelectorAll('.g'); //obtenemos todos los botones agregar el id de cada activida
            
            var idInput6 = document.querySelector('#id-6');
            var idInput7 = document.querySelector('#id-7');

            grupos.forEach(function(grupo) { //a cada modal le pasamos el id de la actividad
                grupo.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var idAux = this.getAttribute('name');
                    idInput6.value = id;
                    idInput7.value = idAux;
                });
            });
        });

    
    </script>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>


</html>
