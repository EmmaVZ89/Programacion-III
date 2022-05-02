<?php
require_once("./clases/Cocinero.php");

use Zelarayan\Cocinero;

$especialidad = isset($_POST["especialidad"]) ? $_POST["especialidad"] : NULL;
$email = isset($_POST["email"]) ? $_POST["email"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;

if($especialidad && $email && $clave) {
    $cocinero = new Cocinero($especialidad, $email, $clave);
    if($cocinero) {
        echo $cocinero->GuardarEnArchivo();
    }
}


?>