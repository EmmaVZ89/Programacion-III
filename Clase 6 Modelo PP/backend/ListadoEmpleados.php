<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Empleado.php");
use Zelarayan\Empleado;
use Zelarayan\AccesoDatos;

$empleados = Empleado::TraerTodos();

// var_dump($empleados);

$tabla = 
"<table>" . 
"<thead>";

foreach ($empleados[0] as $key => $value) {
    if($key != "clave") {
        $tabla .= "<th>" . $key . "</th>";
    }
}
$tabla .= "</thead>";

$tabla .= "<tbody>";
for ($i=0; $i < count($empleados); $i++) { 
    $tabla .= "<tr>";
    foreach ($empleados[$i] as $key => $value) {
        if($key != "clave"){
            if($key == "foto") {
                // le agregue un "." en el src de la imagen
                $tabla .= "<td><img src='." . $value . "' width='50px' alt='img'></td>";
            } else {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
    }
    $tabla .= "</tr>";
}
$tabla .= "</tbody>";
$tabla .= "</table>";


echo $tabla;

?>
