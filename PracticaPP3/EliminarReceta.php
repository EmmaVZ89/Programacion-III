<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");

use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$nombre_get = isset($_GET["nombre"]) ? $_GET["nombre"] : NULL;
$receta_json = isset($_POST["receta_json"]) ? $_POST["receta_json"] : NULL;
$accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
$exito = false;
$mensaje = "No se pudo eliminar la receta";

$recetas = Receta::Traer();

if ($nombre_get) {
    $mensaje = "La receta NO esta en el listado!";
    for ($i = 0; $i < count($recetas); $i++) {
        if (
            $recetas[$i]->nombre == $nombre_get
        ) {
            $exito = true;
            $mensaje = "La receta esta en el listado";
            break;
        }
    }
    echo $mensaje;
} else if ($receta_json) {
    if ($accion == "borrar") {
        $obj = json_decode($receta_json, true);
        $receta = Receta::TraerReceta($obj["id"]);

        if ($receta->Eliminar()) {
            $receta->GuardarEnArchivo();
            $exito = true;
            $mensaje = "Receta Eliminada";
        }
    } else {
        echo "No se indico ninguna accion";
    }
} else {

    $array_recetas = Receta::MostrarBorrados();

    if (count($array_recetas)) {
        $tabla =
            "<h4>LISTA DE RECETAS BORRADAS</h4><br>" .
            "<table>" .
            "<thead>";

        foreach ($array_recetas[0] as $key => $value) {
            $tabla .= "<th>" . $key . "</th>";
        }
        $tabla .= "</thead>";

        $tabla .= "<tbody>";
        for ($i = 0; $i < count($array_recetas); $i++) {
            $tabla .= "<tr>";
            foreach ($array_recetas[$i] as $key => $value) {
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
}

if ($exito) {
    $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

    echo json_encode($retornoJSON);
}
