<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;


$parametroJson = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : NULL;
$exito = false;
$mensaje = "No se pudo encontrar el usuario!";

if($parametroJson) {
    $usuario = Usuario::TraerUno($parametroJson);
    if($usuario) {
        $exito = true;
        $mensaje = "Usuario encontrado!";
    }
}

$array_mensaje = array("exito"=>$exito, "mensaje"=>$mensaje);

$json_mensaje = json_encode($array_mensaje);

echo $json_mensaje;


?>