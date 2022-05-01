<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Televisor.php");
use Zelarayan\Televisor;
use Zelarayan\AccesoDatos;

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : NULL;
$precio = isset($_POST["precio"]) ? (int) $_POST["precio"] : 0;
$paisOrigen = isset($_POST["paisOrigen"]) ? $_POST["paisOrigen"] : NULL;
$foto = isset($_FILES["path"]) ? $_FILES["path"] : NULL;

if($tipo && $precio && $paisOrigen) {
    $path = getPath($foto, $tipo, $paisOrigen);
    $televisor = new Televisor($tipo, $precio, $paisOrigen, $path);
    $televisores = Televisor::Traer();
    if($televisor->Verificar($televisores)) {
        if($televisor->Agregar()){
            guardarImagen($path);
            header("location: Listado.php");
        }
    } else {
        echo "No se pudo agregar el televisor, ya existe!";
    }
}



function getPath(array $foto, string $tipo, string $pais): string
{
	if ($foto != NULL) {
		//INDICO CUAL SERA EL DESTINO DE LA FOTO SUBIDA
		$foto_nombre = $_FILES["path"]["name"];
		$tipoArchivo = pathinfo($foto_nombre, PATHINFO_EXTENSION);
        $nombreArchivo = $tipo . "." . $pais . "." . date("G").date("i").date("s");    
		$path = "./televisores/imagenes/" . $nombreArchivo . "." . $tipoArchivo;
		$uploadOk = TRUE;

		//VERIFICO QUE EL ARCHIVO NO EXISTA
		$array_extensiones = array("jpg", "jpeg", "gif", "png");
		for ($i = 0; $i < count($array_extensiones); $i++) {
			$nombre_archivo = "./televisores/imagenes/" . $nombreArchivo . "." . $array_extensiones[$i];
			if (file_exists($nombre_archivo)) {
				unlink($nombre_archivo);
				break;
			}
		}

		//VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
		if ($_FILES["path"]["size"] > 1000000) {
			$uploadOk = FALSE;
		}

		//OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
		//IMAGEN, RETORNA FALSE
		$esImagen = getimagesize($_FILES["path"]["tmp_name"]);

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
	if(! isset($_FILES["path"])){
		return false;
	}
	return move_uploaded_file($_FILES["path"]["tmp_name"], $path);
}

?>