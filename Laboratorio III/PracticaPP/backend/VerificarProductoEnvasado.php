<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;

$obj_producto = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : NULL;



if($obj_producto) {
    $productos = ProductoEnvasado::traer();
    $obj = json_decode($obj_producto, true);
    $producto = new ProductoEnvasado(0, 0, 0, "", $obj["nombre"], $obj["origen"]);
    
    if($producto->existe($productos)) {
        for ($i = 0; $i < count($productos); $i++) {
            if (
                $productos[$i]->nombre == $producto->nombre &&
                $productos[$i]->origen == $producto->origen
            ) {
                $producto = $productos[$i];
                break;
            }
        }
        echo $producto->ToJSON();
    } else {
        echo "{}";
    }

}