<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;

$tabla_get = isset($_GET["tabla"]) ? $_GET["tabla"] : NULL;

$productos = ProductoEnvasado::traer();

if ($tabla_get == "mostrar") {
    $tabla =
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
                $tabla .= "<td><img src='./BACKEND" . $value . "' width='50px' alt='img'></td>";
            } else {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
        $tabla .= "</tr>";
    }
    $tabla .= "</tbody>";
    $tabla .= "</table>";
    echo $tabla;
} else if($tabla_get == "json") {
    echo json_encode($productos);
    // for ($i=0; $i < count($productos); $i++) { 
    //     $producto = $productos[$i];
    //     echo $producto->ToJSON() . "\n";    
    // }    
}
