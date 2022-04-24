<?php
$productos = $_POST["productos"];
var_dump($productos);

$productos_json = json_decode($_POST["productos"], true);
var_dump($productos_json);

for ($i = 0; $i < count($productos_json); $i++) {
    $producto_std = new stdClass();
    $producto_std->codigoBarra = $productos_json[$i]["codigoBarra"];
    $producto_std->nombre = $productos_json[$i]["nombre"];
    $producto_std->precio = $productos_json[$i]["precio"];
    var_dump($producto_std);
}
