<?php
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$email = isset($_POST["email"]) ? $_POST["email"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

if($email && $clave) {
    $usuario = new Usuario($email, $clave);
    if($usuario) {
        $mensaje = $usuario->GuardarEnArchivo();
        echo $mensaje;
    }
}

// http://localhost/Programacion-III/PracticaPP/
?>

