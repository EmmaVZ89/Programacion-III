<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Receta.php");

use Zelarayan\AccesoDatos;
use Zelarayan\Receta;

$receta_json = isset($_POST["receta_json"]) ? $_POST["receta_json"] : NULL;
$pathFoto = isset($_FILES["pathFoto"]) ? $_FILES["pathFoto"] : NULL;
$exito = false;
$mensaje = "No se pudo modificar la receta";


if ($receta_json) {
    $obj = json_decode($receta_json, true);
    $receta_ori = Receta::TraerReceta($obj["id"]);

    if ($receta_ori) {
        $path = getPath($pathFoto, $obj["nombre"], $obj["tipo"]);
        $receta_mod = new Receta(
            $obj["id"],
            $obj["nombre"],
            $obj["ingredientes"],
            $obj["tipo"],
            $path
        );

        if ($receta_mod->Modificar()) {
            guardarImagen($path);
            $path_actual = $receta_ori->pathFoto;
            $tipoArchivo = pathinfo($path_actual, PATHINFO_EXTENSION);
            $path_destino = "./recetasModificadas/" .
            $receta_ori->nombre . "." . $receta_ori->tipo . ".modificado." . date("G") . date("i") . date("s") . "." . $tipoArchivo;
            
            if($path_actual != "") {
                copy($path_actual, $path_destino);
                unlink($path_actual);    
            }

            $exito = true;
            $mensaje = "Receta modificada";
        }
    }

    $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

    echo json_encode($retornoJSON);
}



function getPath(array $foto, string $nombre, string $tipo): string
{
	if ($foto != NULL) {
		//INDICO CUAL SERA EL DESTINO DE LA FOTO SUBIDA
		$foto_nombre = $_FILES["pathFoto"]["name"];
		$tipoArchivo = pathinfo($foto_nombre, PATHINFO_EXTENSION);
        $nombreArchivo = $nombre . "." . $tipo . "." . date("G").date("i").date("s");    
		$path = "./recetas/imagenes/" . $nombreArchivo . "." . $tipoArchivo;
		$uploadOk = TRUE;

		//VERIFICO QUE EL ARCHIVO NO EXISTA
		$array_extensiones = array("jpg", "jpeg", "gif", "png");
		for ($i = 0; $i < count($array_extensiones); $i++) {
			$nombre_archivo = "./recetas/imagenes/" . $nombreArchivo . "." . $array_extensiones[$i];
			if (file_exists($nombre_archivo)) {
				unlink($nombre_archivo);
				break;
			}
		}

		//VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
		if ($_FILES["pathFoto"]["size"] > 1000000) {
			$uploadOk = FALSE;
		}

		//OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
		//IMAGEN, RETORNA FALSE
		$esImagen = getimagesize($_FILES["pathFoto"]["tmp_name"]);

		if ($esImagen) {
			if (
				$tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
				&& $tipoArchivo != "png"
			) {
				echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
				$uploadOk = FALSE;
			}
		}

		//VERIFICO SI HUBO ALGUN ERROR, CHEQUEANDO $uploadOk
		if ($uploadOk === FALSE) {
			echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
			$path = "";
		}
	}
	return $path;
}

function guardarImagen(string $path): bool
{
	if(! isset($_FILES["pathFoto"])){
		return false;
	}
	return move_uploaded_file($_FILES["pathFoto"]["tmp_name"], $path);
}
