
@extends('layouts.app')
@section('content') 
<div class="container">


<h2>Página principal de empleado</h2>

<p><a href="{{ url('empleado/create') }}" class="btn btn-success"><span class="fas fa-undo-alt">Agregar</span></a></p>

{!! $listado !!}


</div>
@endsection
