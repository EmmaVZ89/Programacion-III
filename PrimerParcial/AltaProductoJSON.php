<?php
require_once("./clases/Producto.php");
use Zelarayan\Producto;

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;

if($nombre && $origen) {
    $producto = new Producto($nombre,$origen);
    if($producto) {
        echo $producto->guardarJSON("./archivos/productos.json");
    }
}


?>