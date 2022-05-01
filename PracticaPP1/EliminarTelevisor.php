<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Televisor.php");

use Zelarayan\Televisor;
use Zelarayan\AccesoDatos;

$tipo_get = isset($_GET["tipo"]) ? $_GET["tipo"] : NULL;
$pais_get = isset($_GET["paisOrigen"]) ? $_GET["paisOrigen"] : NULL;
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$tipo_post = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;
$pais_post = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : NULL;

$televisores = Televisor::Traer();

if ($tipo_get) {
    $televisor = new Televisor($tipo_get, 0, $pais_get);
    if ($televisor->Verificar($televisores)) {
        echo "El televisor NO se encuentra en la lista";
    } else {
        echo "El televisor se encuentra en la lista";
    }
} 
else if ($tipo_post) {
    if ($accion == "borrar") {
        $televisor = null;
        for ($i = 0; $i < count($televisores); $i++) {
            if (
                $televisores[$i]->tipo == $tipo_post &&
                $televisores[$i]->paisOrigen == $pais_post
            ) {
                $televisor = $televisores[$i];
                break;
            }
        }

        if ($televisor) {
            if ($televisor->Eliminar()) {
                $televisor->GuardarEnArchivo();
                header("location: Listado.php");
            } else {
                echo "No se pudo eliminar el Televisor";
            }
        }
    } else {
        echo "No se indico ninguna accion";
    }
} else {

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
}
