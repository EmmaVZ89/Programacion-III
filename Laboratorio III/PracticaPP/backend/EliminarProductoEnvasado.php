<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");
use Zelarayan\AccesoDatos;
use Zelarayan\ProductoEnvasado;

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
$exito = false;
$mensaje = "No se pudo borrar el producto";

if($producto_json) {
    $obj = json_decode($producto_json, true);

    $producto = new ProductoEnvasado(
    $obj["id"],
    0,
    0,
    "",
    $obj["nombre"],
    $obj["origen"]);

    if(ProductoEnvasado::eliminar($producto->id)){
        $exito = true;
        $mensaje = "Producto Eliminado";
        $producto->guardarJSON("./archivos/productos_eliminados.json");
    }
}

$retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

echo json_encode($retornoJSON);
