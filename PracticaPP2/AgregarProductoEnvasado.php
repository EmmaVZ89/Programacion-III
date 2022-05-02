<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/ProductoEnvasado.php");

use Zelarayan\ProductoEnvasado;
use Zelarayan\AccesoDatos;


$codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : NULL;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;
$precio = isset($_POST["precio"]) ? (int) $_POST["precio"] : 0;
$pathFoto = isset($_FILES["pathFoto"]) ? $_FILES["pathFoto"] : NULL;
$exito = false;
$mensaje = "No se pudo agregar el producto";

if($codigoBarra && $nombre && $origen && $precio && $pathFoto) {
    $path = getPath($pathFoto, $nombre, $origen);
    $producto = new ProductoEnvasado(0,$codigoBarra,$precio,$path,$nombre,$origen);
    $productos = ProductoEnvasado::Traer();
    if(! $producto->Existe($productos)) {
        if($producto->Agregar()){
            $exito = true;
            $mensaje = "Producto agregado";
            guardarImagen($path);
        }
    } else {
        $mensaje = "No se pudo agregar el producto, ya existe!";
    }
}

$retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

echo json_encode($retornoJSON);



function getPath(array $foto, string $nombre, string $origen): string
{
	if ($foto != NULL) {
		//INDICO CUAL SERA EL DESTINO DE LA FOTO SUBIDA
		$foto_nombre = $_FILES["pathFoto"]["name"];
		$tipoArchivo = pathinfo($foto_nombre, PATHINFO_EXTENSION);
        $nombreArchivo = $nombre . "." . $origen . "." . date("G").date("i").date("s");    
		$path = "./productos/imagenes/" . $nombreArchivo . "." . $tipoArchivo;
		$uploadOk = TRUE;

		//VERIFICO QUE EL ARCHIVO NO EXISTA
		$array_extensiones = array("jpg", "jpeg", "gif", "png");
		for ($i = 0; $i < count($array_extensiones); $i++) {
			$nombre_archivo = "./productos/imagenes/" . $nombreArchivo . "." . $array_extensiones[$i];
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

?>