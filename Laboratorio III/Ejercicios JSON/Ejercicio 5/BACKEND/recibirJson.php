<?php
$producto = new stdClass();
$producto->codigo = "45187gg";
$producto->nombre = "Pan Bimbo";
$producto->precio = 285;

$objJson = json_encode($producto);

echo $objJson;
