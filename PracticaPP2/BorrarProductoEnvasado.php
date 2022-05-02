<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;

$producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
$exito = false;
$mensaje = "No se pudo eliminar el producto";


if ($producto_json) {
    $obj = json_decode($producto_json, true);

    $producto = new ProductoEnvasado($obj["id"], $obj["codigoBarra"], $obj["precio"],
    $obj["pathFoto"], $obj["nombre"], $obj["origen"]);

    if(ProductoEnvasado::Eliminar($producto->id)) {
        $producto->GuardarEnArchivo();
        $exito = true;
        $mensaje = "Producto eliminado";
    }

    $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

    echo json_encode($retornoJSON);

} else if(count($_GET) == 0){
    $productos = ProductoEnvasado::MostrarBorrados();

    $tabla =
        "<h4>LISTA DE PRODUCTOS BORRADOS</h4><br>" .
        "<table>" .
        "<thead>";

    foreach ($productos[0] as $key => $value) {
        $tabla .= "<th>" . $key . "</th>";
    }
    $tabla .= "</thead>";

    $tabla .= "<tbody>";
    for ($i = 0; $i < count($productos); $i++) {
        $tabla .= "<tr>";
        foreach ($productos[$i] as $key => $value) {
            if ($key == "pathFoto") {
                $tabla .= "<td><img src='" . $value . "' width='50px' alt='img'></td>";
            } else {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
        $tabla .= "</tr>";
    }
    $tabla .= "</tbody>";
    $tabla .= "</table>";

    echo $tabla;
}




