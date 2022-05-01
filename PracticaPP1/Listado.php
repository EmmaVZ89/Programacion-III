<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Televisor.php");

use Zelarayan\Televisor;
use Zelarayan\AccesoDatos;

$televisores = Televisor::Traer();


$tabla =
    "<table>" .
    "<thead>";

foreach ($televisores[0] as $key => $value) {
    $tabla .= "<th>" . $key . "</th>";
}
$tabla .= "<th>IVA inc.</th>";
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
    $tabla .= "<td>" . $televisores[$i]->CalcularIVA()  . "</td>";
    $tabla .= "</tr>";
}
$tabla .= "</tbody>";
$tabla .= "</table>";


echo $tabla;
