<?php

require_once("./clases/accesoDatos.php");
require_once("./clases/Televisor.php");

use Zelarayan\Televisor;
use Zelarayan\AccesoDatos;


$array_televisores = Televisor::MostrarBorrados();

$tabla =
    "<h3>LISTA DE TELEVISORES BORRADOS</h3><br>" .
    "<table>" .
    "<thead>";

foreach ($array_televisores[0] as $key => $value) {
    $tabla .= "<th>" . $key . "</th>";
}
$tabla .= "</thead>";

$tabla .= "<tbody>";
for ($i = 0; $i < count($array_televisores); $i++) {
    $tabla .= "<tr>";
    foreach ($array_televisores[$i] as $key => $value) {
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


echo $tabla;
