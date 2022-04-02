<?php
require_once "./punto.php";
require_once "./rectangulo.php";

$punto1 = new Punto(5,5);
$punto2 = new Punto(15, 10);
$rectangulo = new Rectangulo($punto1, $punto2);

echo $rectangulo->dibujar();
?>