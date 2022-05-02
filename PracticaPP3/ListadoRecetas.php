<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");

use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$recetas = Receta::Traer();

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
echo $tabla;
