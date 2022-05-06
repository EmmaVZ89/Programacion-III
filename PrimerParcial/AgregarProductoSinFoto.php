<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");
use Zelarayan\AccesoDatos;
use Zelarayan\ProductoEnvasado;

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
$exito = false;
$mensaje = "No se pudo agregar el producto";

if($producto_json) {
    $obj = json_decode($producto_json, true);

    $producto = new ProductoEnvasado(
    0,
    $obj["codigoBarra"],
    $obj["precio"],
    "",
    $obj["nombre"],
    $obj["origen"]);

    if($producto->agregar()){
        $exito = true;
        $mensaje = "Producto agregado";
    }
}

$retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

echo json_encode($retornoJSON);
