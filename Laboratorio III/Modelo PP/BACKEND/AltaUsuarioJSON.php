<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;

if($correo && $clave && $nombre) {
    $usuario = new Usuario(0,$nombre,$correo,$clave);
    if($usuario) {
        echo $usuario->GuardarEnArchivo();
    }
}


?>