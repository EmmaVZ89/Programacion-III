<?php
$producto = $_POST["producto"];
var_dump($producto);

$producto_json = json_decode($_POST["producto"], true);
var_dump($producto_json);

$producto_std = new stdClass();
$producto_std->codigoBarra = $producto_json["codigoBarra"];
$producto_std->nombre = $producto_json["nombre"];
$producto_std->precio = $producto_json["precio"];

var_dump($producto_std);

?>