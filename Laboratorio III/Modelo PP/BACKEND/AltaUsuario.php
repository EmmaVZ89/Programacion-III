<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$id_perfil = isset($_POST["id_perfil"]) ? (int) $_POST["id_perfil"] : 0;
$exito = false;
$mensaje = "No se pudo agregar el usuario!";

if($correo && $clave && $nombre && $id_perfil) {
    $usuario = new Usuario(0, $nombre, $correo, $clave, $id_perfil);
    if($usuario->Agregar()) {
        $exito = true;
        $mensaje = "Usuarios agregado!";
    }
}

$array_mensaje = array("exito"=>$exito, "mensaje"=>$mensaje);

$json_mensaje = json_encode($array_mensaje);

echo $json_mensaje;
