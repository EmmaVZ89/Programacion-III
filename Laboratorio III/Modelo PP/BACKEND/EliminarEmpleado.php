<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Empleado.php");

use Zelarayan\Empleado;
use Zelarayan\AccesoDatos;

$id_eliminar = isset($_POST["id"]) ? (int) $_POST["id"] : 0;

$exito = false;
$mensaje = "El empleado no existe";

if ($id_eliminar) {
    if (Empleado::Eliminar($id_eliminar)) {
        $exito = true;
        $mensaje = "Empleado Eliminado";
    } else {
        $mensaje = "No se pudo eliminar el empleado";
    }
}

$array_mensaje = array("exito" => $exito, "mensaje" => $mensaje);

$json_mensaje = json_encode($array_mensaje);

echo $json_mensaje;
