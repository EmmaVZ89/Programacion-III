<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$usuarios = Usuario::TraerTodos();

$tabla = 
"<table>" . 
"<thead>";

foreach ($usuarios[0] as $key => $value) {
    if($key != "clave") {
        if($key != "id_perfil") {
            $tabla .= "<th>" . $key . "</th>";
        }
    }
}
$tabla .= "<th>ACCIONES</th>";
$tabla .= "</thead>";

$tabla .= "<tbody>";
for ($i=0; $i < count($usuarios); $i++) { 
    $tabla .= "<tr>";
    foreach ($usuarios[$i] as $key => $value) {
        if($key != "clave"){
            if($key != "id_perfil") {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
    }
    $usuario = json_encode($usuarios[$i]);
    $tabla .= "<td><input type='button' value='Modificar' onclick='ModeloParcial.ModificarUsuario({$usuario})'></td>";
    $tabla .= "<td><input type='button' value='Eliminar' onclick='ModeloParcial.EliminarUsuario({$usuario})'></td>";
    $tabla .= "</tr>";
}
$tabla .= "</tbody>";
$tabla .= "</table>";

echo $tabla;
