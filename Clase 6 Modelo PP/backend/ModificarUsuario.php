<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$usuario_json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : NULL;
$exito = false;
$mensaje = "El usuario no existe!";

if($usuario_json) {
    $usuarioObj = json_decode($usuario_json, true);
    $usuario = new Usuario($usuarioObj["id"], $usuarioObj["nombre"], $usuarioObj["correo"],
    $usuarioObj["clave"], $usuarioObj["id_perfil"]);
    if($usuario) {
        if($usuario->Modificar()){
            $exito = true;
            $mensaje = "Usuario Modificado!";
        } else {
            $mensaje = "No se pudo modificar el usuario!";
        }
    }
}

$array_mensaje = array("exito"=>$exito, "mensaje"=>$mensaje);

$json_mensaje = json_encode($array_mensaje);

echo $json_mensaje;


?>