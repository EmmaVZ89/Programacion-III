<?php

$array_productos = array();

$producto1 = new stdClass();
$producto1->codigo = "45187gg";
$producto1->nombre = "Pan Bimbo";
$producto1->precio = 285;

$producto2 = new stdClass();
$producto2->codigo = "999trty";
$producto2->nombre = "Pan sin marca";
$producto2->precio = 200;

$producto3 = new stdClass();
$producto3->codigo = "888asdf";
$producto3->nombre = "Pan Fargo";
$producto3->precio = 320;

array_push($array_productos, $producto1, $producto2, $producto3);  

$objJson = json_encode($array_productos);

echo $objJson;
