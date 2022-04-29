<?php
require_once("./clases/accesoDatos.php");
require_once("./clases/Empleado.php");
use Zelarayan\Empleado;
use Zelarayan\AccesoDatos;

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : NULL;
$sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : NULL;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;
$exito = false;
$mensaje = "No se pudo guardar el empleado";

if($nombre && $correo && $clave && $id_perfil && $sueldo && $foto) {
    $path = getPath($foto, $nombre);
    $empleado = new Empleado(0,$nombre,$correo,$clave,$id_perfil,"",$path,$sueldo);
    if($empleado->Agregar()){
        $exito = true;
        $mensaje = "Empleado agregado!";
        guardarImagen($path);
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
	return move_uploaded_file($_FILES["foto"]["tmp_name"], "." . $path); // ojo con el puntito (0)U(0)
}

?>