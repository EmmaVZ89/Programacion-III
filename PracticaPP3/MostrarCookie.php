<?php

$especialidad = isset($_GET["especialidad"]) ? $_GET["especialidad"] : NULL;
$email = isset($_GET["email"]) ? $_GET["email"] : NULL;
$exito = false;
$mensaje = "La cookie no existe";

if($especialidad && $email) {
    $existe_cookie = false;
    $cookie = $email . "_" . $especialidad;
    foreach ($_COOKIE as $key => $value) {
        if($key == $cookie) {
            $existe_cookie = true;
            $exito = true;
            $mensaje = "La cookie existe. Nombre: " . $cookie;
            break;
        }
    }
}

$retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

echo json_encode($retornoJSON);

?>