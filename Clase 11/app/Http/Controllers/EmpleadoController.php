<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

//PARA ELIMINAR FOTOS DEL STORAGE
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //OBTENGO DATOS DESDE LA BD - APLICO PAGINACION AL LISTADO
        $datos["empleados"] = Empleado::paginate(3);//all();

        //OBTENGO LA VISTA CON EL LISTADO
        $vista_listado = view('empleado.listado', $datos);

        //RETORNO LA VISTA DEL INDEX
        return view('empleado.index', ['listado' => $vista_listado]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //OBTENGO LA VISTA DEL FORMULARIO
        $vista_form = view('empleado.form', ["url" => "/empleado"]);

        //RETORNO LA VISTA PARA AGREGAR UN EMPLEADO
        return view('empleado.agregar', ["form" => $vista_form]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //AGREGO LAS VALIDACIONES PARA LOS DISTINTOS CAMPOS
        $campos = [
            "nombre" => "required|string|min:3|max:20",
            "apellido" => "required|string|min:3|max:30",
            "correo" => "required|email",
            "clave" => "required|string|min:4|max:8",
            "foto" => "required|max:10000|mimes:jpeg,png,jpg",
        ];

        //AGREGO LOS MENSAJES PERSONALIZADOS / GENERICOS
        $mensajes = [
            "required" => "El :attribute es requerido!",
            "clave.required" => "La clave es requerida!",
            "foto.required" => "La foto es requerida!",
            "min" => "El :attribute debe tener al menos :min caracteres!",
            "max" => "El :attribute debe tener a lo sumo :max caracteres!",
            "clave.min" => "La clave debe tener al menos :min caracteres!",
            "clave.max" => "La clave debe tener a lo sumo :max caracteres!",
        ];

        //APLICO LAS VALIDACIONES
        $this->validate($request, $campos, $mensajes);

        //OBTENGO TODOS LOS DATOS ENVIADOS
        //$datos = request()->all();

        //OBTENGO TODOS LOS DATOS ENVIADOS A EXCEPCION DEL _TOKEN
        $datos = request()->except("_token");

        //VERIFICO SI SE ENVIO UNA IMAGEN
        if($request->hasFile("foto")){

            $datos["foto"] = $request->file("foto")->store("fotos", "public");
        }

        //INVOCO AL MODELO PARA DAR DE ALTA UN NUEVO EMPLEADO
        Empleado::insert($datos);

        return response()->json($datos, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show($id)//se cambia Empleado $empleado por $id
    {
        //BUSCO EMPLEADO POR ID
        $empleado = Empleado::findOrFail($id);

        //INDICO LA RUTA
        $url = "/empleado";

        $vista_form = view('empleado.form', ["url" => $url, "empleado" => $empleado, "mostrar" => true]);
    
        return view("empleado.mostrar", ["form" => $vista_form]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//se cambia Empleado $empleado por $id
    {
        //BUSCO EMPLEADO POR ID
        $empleado = Empleado::findOrFail($id);

        //INDICO LA RUTA
        $url = "/empleado/" . $id;

        //INDICO EL MÉTODO DEL FORM
        $metodo = "PUT";

        $vista = view('empleado.form', ["url" => $url,"empleado" => $empleado, "metodo" => $metodo]);

        return view('empleado.modificar', ["form" => $vista]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        //AGREGO LAS VALIDACIONES PARA LOS DISTINTOS CAMPOS
        $campos = [
            "nombre" => "required|string|min:3|max:20",
            "apellido" => "required|string|min:3|max:30",
            "correo" => "required|email",
            "clave" => "required|string|min:4|max:8",            
        ];

        //AGREGO LOS MENSAJES PERSONALIZADOS / GENERICOS
        $mensajes = [
            "required" => "El :attribute es requerido!",
            "clave.required" => "La clave es requerida!",           
            "min" => "El :attribute debe tener al menos :min caracteres!",
            "max" => "El :attribute debe tener a lo sumo :max caracteres!",
            "clave.min" => "La clave debe tener al menos :min caracteres!",
            "clave.max" => "La clave debe tener a lo sumo :max caracteres!",
        ];

        //VERIFICO SI SE ENVIO UNA IMAGEN
        if($request->hasFile("foto")){

            $campos = [ "foto" => "required|max:10000|mimes:jpeg,png,jpg",];
            $mensajes = [ "foto.required" => "La foto es requerida!",];
        }

        //APLICO LAS VALIDACIONES
        $this->validate($request, $campos, $mensajes);

        //OBTENGO TODOS LOS DATOS ENVIADOS A EXCEPCION DEL _TOKEN y _METHOD
        $datos = request()->except("_token", "_method");

        //VERIFICO SI SE ENVIO UNA IMAGEN
        if($request->hasFile("foto")){

            Storage::delete("public/" . $datos["foto_original"]);

            $datos["foto"] = $request->file("foto")->store("fotos", "public");
        }

        //ELIMINO FOTO_ORIGINAL DE $DATOS
        unset($datos["foto_original"]);

        //INVOCO AL MODELO PARA MODIFICAR UN EMPLEADO POR ID
        Empleado::where("id", "=", $datos["id"])->update($datos);

        //REDIRECCIONO HACIA EL LISTADO
        return redirect("empleado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        //BORRO LA IMAGEN
        Storage::delete("public/" . $empleado["foto"]);

        //INVOCO AL MODELO PARA ELIMINAR UN EMPLEADO POR ID
        $cantidad = Empleado::destroy($empleado["id"]);

        $arr_rta = [];
        $arr_rta["exito"] = $cantidad == 1 ? true : false;
        $arr_rta["status"] = $cantidad == 1 ? 200 : 500;

        return $arr_rta;
    }

    //AGREGO MÉTODO PARA PODER BORRAR UN EMPLEADO
    public function borrar($id)
    {
        //BUSCO EMPLEADO POR ID
        $empleado = Empleado::findOrFail($id);

        $rta = $this->destroy($empleado);

        return response()->json($rta, $rta["status"]);
    }
}
