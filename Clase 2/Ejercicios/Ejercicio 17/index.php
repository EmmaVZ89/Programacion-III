<?php

$recuperatorio = "Recuperatorio";
$parcial = "Parcial";
$programacion = "Programacion";
$perro = "perro";
$palabra = "palabra";

echo $recuperatorio . ": " . validarPalabra($recuperatorio, 15) . "<br>";
echo $parcial . ": " . validarPalabra($parcial, 10) . "<br>";
echo $programacion . ": " . validarPalabra($programacion, 15) . "<br>";
echo $perro . ": " . validarPalabra($perro, 6) . "<br>";
echo $palabra . ": " . validarPalabra($palabra, 5) . "<br>";

function validarPalabra(string $palabra, int $max):int{
    $retorno = 0;
    if(strlen($palabra) <= $max){
        switch ($palabra) {
            case "Recuperatorio":
                $retorno = 1;
                break;
            case "Parcial":
                $retorno = 1;
                break;
            case "Programacion":
                $retorno = 1;
                break;
        }
    }
    return $retorno;
}
?>