<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$id_eliminar = isset($_POST["id"]) ? (int) $_POST["id"] : 0;
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$exito = false;
$mensaje = "El usuario no existe";

if($id_eliminar && $accion) {
    if($accion == "borrar") {
        if(Usuario::Eliminar($id_eliminar)) {
            $exito = true;
            $mensaje = "Usuario Eliminado";
        } else {
            $mensaje = "No se pudo eliminar el usuario";
        }
    }
}

$array_mensaje = array("exito"=>$exito, "mensaje"=>$mensaje);

$json_mensaje = json_encode($array_mensaje);

echo $json_mensaje;


?>