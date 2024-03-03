<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
    <style>
        
    </style>
</head>
<body>
    @if(session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
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

    <div class="container-fluid row mt-4 ">
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
                    Administra usuarios en esta sección. Al presionar "Añadir usuario" <i class="fas fa-plus"></i>, puedes añadir usuarios a la lista de usuarios. También realizar ediciones <i class="fas fa-edit"></i> o eliminar el usuario seleccionado <i class="fas fa-trash-alt"></i>, así como otorgarle permisos de "profesor" <i class="fas fa-chalkboard-teacher"></i> o "administrador" <i class="fas fa-user-shield"></i>. Al asignarle un permiso,
                    si el usuario ya contiene uno, se cambiará a este nuevo.
                </p>
                
                
                <hr>
                <div class="card-footer text-center"> <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#agregarProfesorModal"><i class="fas fa-plus"></i> Añadir usuario</a> </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mb-3">
        <form action="{{route('admin.CRUD.post')}}" method="post" id="form">
            @csrf
            <select class="form-control" name="opcionMostrar" onchange="enviar()" >
                <option>Filtrar</option>
                <hr class="bg-secondary">
                <option value="todos" class="p-4">Todos</option>
                <option value="admin">Administradores</option>
                <option value="profesores">Profesores</option>
            </select>
        </form>
    </div>

    @if(isset($usuarios) && count($usuarios) != 0) <!-- Si la variable usuarios existe y es distinta de 0 -->
        <div class="container">
            <div class="row row-cols-1 row-cols-xl-3">
                @foreach($usuarios as $usuario)
                    <div class="col mb-4">
                        <div class="card">
                            <div class="card-header text-center bg-primary text-white">
                                <h5 class="card-title"><i class="fas fa-id-card"></i> {{$usuario->name}}</h5>
                            </div>
                            <div class="card-body text-center">
                                <p class="fs-5"><i class="fas fa-envelope"></i> {{$usuario->email}}</p>
                            </div>
                            <div class="alert alert-warning d-flex justify-content-center align-items-center fs-4" role="alert">
                                @if($usuario->role_id == "1")
                                    <p><i class="fas fa-user-shield"></i></i> Administrador</p>
                                @elseif($usuario->role_id == "2")
                                    <p><i class="fas fa-chalkboard-teacher"></i> Profesor</p>
                                @else
                                    <p><i class="fas fa-exclamation-triangle"></i> Usuario sin rol</p>
                                @endif
                            </div>
                            <div class="card-footer text-center">
                                <button type="button" class="btn btn-warning btnEditar" data-toggle="modal" data-target="#editarProfesorModal" data-id="{{$usuario->id}}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button type="button" class="btn btn-danger btnEliminar" data-toggle="modal" data-target="#borrarProfesorModal" data-id="{{$usuario->id}}">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                <button type="button" class="btn btn-success btnPermisos" data-toggle="modal" data-target="#permisosProfesorModal" data-id="{{$usuario->id}}">
                                    <i class="fas fa-unlock-alt"></i> Permisos
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-warning d-flex flex-column align-items-center" role="alert">
            <i class="fas fa-info-circle fa-2x g-2"></i>
            <p>No hay profesores disponibles en este momento.</p>
        </div>
    @endif

    <div class="d-flex justify-content-center">
        <a href="{{route('profesor.CRUD')}}" class="btn btn-primary mb-4 mt-4"><i class="fas fa-arrow-left"></i>  Actividades</a>
    </div>

    <hr>
    


    <div class="modal fade" id="agregarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="agregarProfesorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarActividadModalLabel">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('agregar.usuario')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombreUsuario"><i class="fas fa-user-circle"></i> Nombre del Usuario</label>
                            <input type="text" class="form-control" id="nombreProfesor" name="nombreUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="emailUsuario"><i class="fas fa-envelope"></i> Email del Usuario</label>
                            <input type="email" class="form-control" id="emailProfesor" name="emailUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordUsuario"><i class="fas fa-lock"></i> Contraseña</label>
                            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" required>
                        </div>
                        <div class="badge bg-success mt-2">Con permisos</div>
                        <select class="form-control" id="permisosSelect" name="rol" required>
                            @foreach($roles as $rol)
                                <option value="{{$rol->name}}">{{$rol->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="editarProfesorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarActividadModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('editar.usuario')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="usuario_id" id="usuario_id" class="d-none">
                        <div class="form-group">
                            <label for="nombreUsuario"><i class="fas fa-user-circle"></i> Nombre del Usuario</label>
                            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario">
                        </div>
                        <div class="form-group">
                            <label for="emailUsuario"><i class="fas fa-envelope"></i> Email del Usuario</label>
                            <input type="email" class="form-control" id="emailUsuario" name="emailUsuario">
                        </div>
                        <div class="form-group">
                            <label for="passwordUsuario"><i class="fas fa-lock"></i> Contraseña</label>
                            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario">
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

    <div class="modal fade" id="borrarProfesorModal" tabindex="-1" role="dialog" aria-labelledby="borrarProfesorModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarActividadModalLabel">Eliminar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('eliminar.usuario')}}" method="POST">
                    @csrf
                    <input type="text" name="usuario_id" id="usuario_id1" class="d-none">
                    <div class="alert alert-danger m-1 p-3 text-center"><i class="fas fa-exclamation-triangle"></i> Eliminarás permanentemente al usuario</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="permisosProfesorModal" tabindex="-1" role="dialog" aria-labelledby="permisosProfesorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarActividadModalLabel">Permisos Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="{{route('permisos.usuario')}}" method="POST" class="p-2">
                    @csrf
                    <input type="text" name="usuario_id" id="usuario_id2" class="d-none">
                    <div class="badge bg-success mb-2">Permisos</div>
                    
                    <select class="form-control" id="permisosSelect" name="permiso">
                        @foreach($roles as $rol)
                            <option value="{{$rol->name}}">{{$rol->name}}</option>
                        @endforeach
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let botonesEditar = document.querySelectorAll('.btnEditar');
        let input = document.getElementById('usuario_id');
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', function(){
                let usuarioId = this.getAttribute('data-id');
                input.value = usuarioId;
            })
        });

        let botonesBorrar = document.querySelectorAll('.btnEliminar');
        let input1 = document.getElementById('usuario_id1');
        botonesBorrar.forEach(boton => {
            boton.addEventListener('click', function(){
                let usuarioId = this.getAttribute('data-id');
                input1.value = usuarioId;
            })
        });

        let botonesPermisos = document.querySelectorAll('.btnPermisos');
        let input2 = document.getElementById('usuario_id2');
        botonesPermisos.forEach(boton => {
            boton.addEventListener('click', function(){
                let usuarioId = this.getAttribute('data-id');
                input2.value = usuarioId;
            })
        });

        function enviar() {
            document.getElementById("form").submit();
        }

    </script>
            
           

   

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>

