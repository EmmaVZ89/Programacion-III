<?php
require_once "./figura_geometrica.php";
require_once "./rectangulo.php";
require_once "./triangulo.php";

$rectangulo = new Rectangulo(7, 4);
$rectangulo->setColor("violet");
echo $rectangulo->toString();

$triangulo = new Triangulo(3, 5);
$triangulo->setColor("red");
echo $triangulo->toString();
?>