<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Empleado.php");
use Zelarayan\Empleado;
use Zelarayan\AccesoDatos;


$empleado_json = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : NULL;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;
$path = "";
$exito = false;
$mensaje = "El empleado no existe!";


if($empleado_json) {
    $empleadoObj = json_decode($empleado_json, true);

    if($foto) {
        $path = getPath($foto, $empleadoObj["nombre"]);
        $empleado = new Empleado($empleadoObj["id"], $empleadoObj["nombre"], $empleadoObj["correo"],
        $empleadoObj["clave"], $empleadoObj["id_perfil"], "" , $path, $empleadoObj["sueldo"]);
    } else {
        $empleado = new Empleado($empleadoObj["id"], $empleadoObj["nombre"], $empleadoObj["correo"],
        $empleadoObj["clave"], $empleadoObj["id_perfil"], "" , $empleadoObj["path_foto"], $empleadoObj["sueldo"]);
    }

    if($empleado) {
        if($empleado->Modificar()){
            $exito = true;
            $mensaje = "Empleado Modificado!";

            if($path != ""){
                guardarImagen($path);
            }
        } else {
            $mensaje = "No se pudo modificar el empleado!";
        }
    }
}

$array_mensaje = array("exito"=>$exito, "mensaje"=>$mensaje);

$json_mensaje = json_encode($array_mensaje);

echo $json_mensaje;



function getPath(array $foto, string $nombre): string
{
	if ($foto != NULL) {
		//INDICO CUAL SERA EL DESTINO DE LA FOTO SUBIDA
		$foto_nombre = $_FILES["foto"]["name"];
		$tipoArchivo = pathinfo($foto_nombre, PATHINFO_EXTENSION);
        $nombreArchivo = $nombre . "." . date("G").date("i").date("s");    
		$path = "./backend/empleados/fotos/" . $nombreArchivo . "." . $tipoArchivo;
		$uploadOk = TRUE;

		//VERIFICO QUE EL ARCHIVO NO EXISTA
		$array_extensiones = array("jpg", "jpeg", "gif", "png");
		for ($i = 0; $i < count($array_extensiones); $i++) {
			$nombre_archivo = "./backend/empleados/fotos/" . $nombreArchivo . "." . $array_extensiones[$i];
			if (file_exists($nombre_archivo)) {
				unlink($nombre_archivo);
				break;
			}
		}

		//VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
		if ($_FILES["foto"]["size"] > 1000000) {
			$uploadOk = FALSE;
		}

		//OBTIENE EL TAMAÑO DE UNA IMAGEN, SI EL ARCHIVO NO ES UNA
		//IMAGEN, RETORNA FALSE
		$esImagen = getimagesize($_FILES["foto"]["tmp_name"]);

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
	if(! isset($_FILES["foto"])){
		return false;
	}
	return move_uploaded_file($_FILES["foto"]["tmp_name"], "." . $path); // ojo con el punto
}
