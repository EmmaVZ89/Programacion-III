<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;

$productos = ProductoEnvasado::Traer();
$array_filtrado = array();


if ($nombre && $origen) {
    for ($i = 0; $i < count($productos); $i++) {
        if ($productos[$i]->nombre == $nombre && $productos[$i]->origen == $origen) {
            array_push($array_filtrado, $productos[$i]);
        }
    }

    if (count($array_filtrado)) {
        echo ArmarTabla($array_filtrado);
    }
} else if ($nombre) {
    for ($i = 0; $i < count($productos); $i++) {
        if ($productos[$i]->nombre == $nombre) {
            array_push($array_filtrado, $productos[$i]);
        }
    }

    if (count($array_filtrado)) {
        echo ArmarTabla($array_filtrado);
    }
} else if ($origen) {
    for ($i = 0; $i < count($productos); $i++) {
        if ($productos[$i]->origen == $origen) {
            array_push($array_filtrado, $productos[$i]);
        }
    }

    if (count($array_filtrado)) {
        echo ArmarTabla($array_filtrado);
    }
}




function ArmarTabla(array $productos): string
{
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
                $tabla .= "<td><img src='" . $value . "' width='50px' alt='img'></td>";
            } else {
                $tabla .= "<td>" . $value . "</td>";
            }
        }
        $tabla .= "</tr>";
    }
    $tabla .= "</tbody>";
    $tabla .= "</table>";

    return $tabla;
}
