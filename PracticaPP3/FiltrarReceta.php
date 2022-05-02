<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");

use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;

$recetas = Receta::Traer();
$array_filtrado = array();


if ($nombre && $tipo) {
    for ($i = 0; $i < count($recetas); $i++) {
        if ($recetas[$i]->nombre == $nombre && $recetas[$i]->tipo == $tipo) {
            array_push($array_filtrado, $recetas[$i]);
        }
    }
} else if ($nombre) {
    for ($i = 0; $i < count($recetas); $i++) {
        if ($recetas[$i]->nombre == $nombre) {
            array_push($array_filtrado, $recetas[$i]);
        }
    }
} else if ($tipo) {
    for ($i = 0; $i < count($recetas); $i++) {
        if ($recetas[$i]->tipo == $tipo) {
            array_push($array_filtrado, $recetas[$i]);
        }
    }
}

if (count($array_filtrado)) {
    echo ArmarTabla($array_filtrado);
}



function ArmarTabla(array $recetas): string
{
    $tabla =
        "<table>" .
        "<thead>";

    foreach ($recetas[0] as $key => $value) {
        $tabla .= "<th>" . $key . "</th>";
    }
    $tabla .= "</thead>";

    $tabla .= "<tbody>";
    for ($i = 0; $i < count($recetas); $i++) {
        $tabla .= "<tr>";
        foreach ($recetas[$i] as $key => $value) {
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
