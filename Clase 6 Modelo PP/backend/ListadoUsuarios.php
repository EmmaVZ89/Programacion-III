<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$usuarios = Usuario::TraerTodos();

// var_dump($usuarios);

$tabla = 
"<table>" . 
"<thead>";

foreach ($usuarios[0] as $key => $value) {
    if($key != "clave") {
        $tabla .= "<th>" . $key . "</th>";
    }
}
$tabla .= "</thead>";

$tabla .= "<tbody>";
for ($i=0; $i < count($usuarios); $i++) { 
    $tabla .= "<tr>";
    foreach ($usuarios[$i] as $key => $value) {
        if($key != "clave"){
            $tabla .= "<td>" . $value . "</td>";
        }
    }
    $tabla .= "</tr>";
}
$tabla .= "</tbody>";
$tabla .= "</table>";

echo $tabla;
?>