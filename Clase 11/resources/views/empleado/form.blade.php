<?php
$empleado = isset($empleado) ? $empleado : NULL;
$id = $empleado !== NULL ? $empleado->id : "";
$nombre = $empleado !== NULL ? $empleado->nombre : old("nombre");
$apellido = $empleado !== NULL ? $empleado->apellido : old("apellido");
$correo = $empleado !== NULL ? $empleado->correo : old("correo");
$foto = $empleado !== NULL ? $empleado->foto : "";
$mostrar = isset($mostrar) ? $mostrar : FALSE;
$metodo = isset($metodo) ? $metodo : NULL;
?>

{{-- AGREGO LAS VALIDACIONES DE LOS CAMPOS --}}

@if(count($errors) > 0)

<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>

@endif

<h2>Formulario empleado</h2>

<div class="row">
    <div class="col-md-8">

        <form action="{{ url($url) }}" method="post" enctype="multipart/form-data" class="form">
        {{-- SE AGREGA TOKEN DE SEGURIDAD DE LARAVEL --}}
        @csrf 

        {{-- SE ESTABLECEN MÉTODOS: PUT / DELETE, SEGÚN CORRESPONDA --}}
        @if($metodo !== NULL)
            {{ method_field($metodo) }}
        @endif
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="{{$id}}" readonly>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{$nombre}}" placeholder="Introduce tu nombre">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="{{$apellido}}" placeholder="Introduce tu apellido">
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="{{$correo}}" placeholder="Introduce tu correo">
            </div>
            @if($mostrar === FALSE)
            <div class="form-group">
                <label for="clave">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Clave">
            </div>
            <div class="form-group">
                <label for="foto">Adjuntar un archivo</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>
            @endif
            @if($empleado !== NULL)
            <div class="form-group">
                <img src="{{ asset('storage') . '/' . $foto}}" height="200px" width="170px" >
                <input type="hidden" name="foto_original" value="{{ $foto }}" >
            </div>
            @endif
            @if($mostrar === FALSE)
                <button type="submit" class="btn btn-primary">Enviar</button>
            @endif

            <a href="{{ url('empleado') }}" class="btn btn-success"><span class="fas fa-undo-alt">Volver</span></a>

        </form>

    </div>
</div>