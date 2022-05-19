<?php

$nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : NULL;
$origen = isset($_GET["origen"]) ? $_GET["origen"] : NULL;
$exito = false;
$mensaje = "La cookie no existe";

if($nombre && $origen) {
    $existe_cookie = false;
    $cookie = $nombre . "_" . $origen;
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