<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Televisor.php");

use Zelarayan\Televisor;
use Zelarayan\AccesoDatos;

$tipo_post = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;
$pais_post = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : NULL;

$televisores = Televisor::Traer();
$array_filtrado = array();


if ($tipo_post && $pais_post) {
    for ($i = 0; $i < count($televisores); $i++) {
        if ($televisores[$i]->tipo == $tipo_post && $televisores[$i]->paisOrigen == $pais_post) {
            array_push($array_filtrado, $televisores[$i]);
        }
    }

    if (count($array_filtrado)) {
        echo ArmarTabla($array_filtrado);
    }
} else if ($tipo_post) {
    for ($i = 0; $i < count($televisores); $i++) {
        if ($televisores[$i]->tipo == $tipo_post) {
            array_push($array_filtrado, $televisores[$i]);
        }
    }

    if (count($array_filtrado)) {
        echo ArmarTabla($array_filtrado);
    }
} else if ($pais_post) {
    for ($i = 0; $i < count($televisores); $i++) {
        if ($televisores[$i]->paisOrigen == $pais_post) {
            array_push($array_filtrado, $televisores[$i]);
        }
    }

    if (count($array_filtrado)) {
        echo ArmarTabla($array_filtrado);
    }
}




function ArmarTabla(array $televisores): string
{
    $tabla =
        "<table>" .
        "<thead>";

    foreach ($televisores[0] as $key => $value) {
        $tabla .= "<th>" . $key . "</th>";
    }
    $tabla .= "</thead>";

    $tabla .= "<tbody>";
    for ($i = 0; $i < count($televisores); $i++) {
        $tabla .= "<tr>";
        foreach ($televisores[$i] as $key => $value) {
            if ($key == "path") {
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
