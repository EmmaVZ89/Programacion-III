<?php
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$email = isset($_POST["email"]) ? $_POST["email"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

// $email = "emma@emma.com";
// $clave = 123456;
if($email && $clave) {
    $usuario = new Usuario($email, $clave);
    if(Usuario::VerificarExistencia($usuario)) {
        setcookie($email, date("YmdGis"), time() + 3600, "/");
        header("location: ListadoUsuarios.php");
    } else {
        echo "El usuario no se encuentra en el listado";
    }
}


?>