<h2>Listado de empleados</h2>

<table class="table table-dark table-hover w-75">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>CORREO</th>
            <th>FOTO</th>
            <th>ACCIONES</th>
        </tr>
    </thead>

    <tbody>
    @foreach($empleados as $empleado)
        <tr>
            <td>{{ $empleado->id }}</td>
            <td>{{ $empleado->nombre }}</td>
            <td>{{ $empleado->apellido }}</td>
            <td>{{ $empleado->correo }}</td>
            <td>
                <img src="{{ asset('storage') . '/' . $empleado->foto }}" alt="" height="60px" width="60px" class="img-thumbnail"> 
            </td>
            <td>
                <a href="{{ url('empleado') . '/' . $empleado->id }}" class="btn btn-success"><span class="fas fa-search-plus">Mostrar</span></a>
                <a href="{{ url('/empleado/' . $empleado->id . '/edit') }}" class="btn btn-info"><span class="far fa-edit">Modificar</span></a>
                <a href="{{ url('/empleado/borrar') . '/' . $empleado->id }}" class="btn btn-danger"><span class="far fa-trash-alt">Eliminar</span></a>
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>

    </tfoot>
</table>

{{-- AGREGO LOS LINKS DEL PAGINADOR --}}
{!! $empleados->links() !!}