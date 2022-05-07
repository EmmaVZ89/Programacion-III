<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Empleado.php");
use Zelarayan\Empleado;
use Zelarayan\AccesoDatos;

$empleados = Empleado::TraerTodos();

$tabla = 
"<table>" . 
"<thead>";

foreach ($empleados[0] as $key => $value) {
    if($key != "clave") {
        $tabla .= "<th>" . $key . "</th>";
    }
}
$tabla .= "<th>ACCIONES</th>";
$tabla .= "</thead>";

$tabla .= "<tbody>";
for ($i=0; $i < count($empleados); $i++) { 
    $tabla .= "<tr>";
    foreach ($empleados[$i] as $key => $value) {
        if($key != "clave"){
            if($key == "foto") {
                $tabla .= "<td><img src='" . $value . "' width='50px' alt='img'></td>";
            } else {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
    }
    $empleado = json_encode($empleados[$i]);
    $tabla .= "<td><input type='button' value='Modificar' onclick='ModeloParcial.ModificarEmpleado({$empleado})'></td>";
    $tabla .= "<td><input type='button' value='Eliminar' onclick='ModeloParcial.EliminarEmpleado({$empleado})'></td>";
    $tabla .= "</tr>";
}
$tabla .= "</tbody>";
$tabla .= "</table>";


echo $tabla;

?>
