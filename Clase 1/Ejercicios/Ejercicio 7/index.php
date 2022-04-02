<?php
$fecha = date("d-m-Y");
echo $fecha . "<br>";
$fecha = date("Y-m-d", strtotime($fecha));
echo $fecha . "<br>";
$fecha = date("F j, Y, g:i a", strtotime($fecha));
echo $fecha . "<br>";

$dia = date("z");
$estacion;

/*
otoño 79 / 80
invierno 172 / 173
primavera 265 / 266
verano 352 / 353
*/

if($dia <= 79){
    $estacion = "Otoño";
} else if($dia <= 172){
    $estacion = "Invierno";
} else if($dia <= 265){
    $estacion = "Primavera";
} else if($dia <= 352){
    $estacion = "Verano";
} else {
    $estacion = "Otoño";
}

echo "La estacion es " . $estacion;
?>