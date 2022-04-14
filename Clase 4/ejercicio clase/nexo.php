<?php
require_once("./alumno.php");

use Zelarayan\Alumno;


//RECUPERO TODOS LOS VALORES (POST)
$accion = isset($_REQUEST["accion"]) ? (int) $_REQUEST["accion"] : 0;
$legajo = isset($_REQUEST["legajo"]) ? (int) $_REQUEST["legajo"] : 0;
$nombre = isset($_REQUEST["nombre"]) ? $_REQUEST["nombre"] : NULL;
$apellido = isset($_REQUEST["apellido"]) ? $_REQUEST["apellido"] : NULL;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;
$path = "";

//****************************************** */
//CRUD - SOBRE ARCHIVOS
//****************************************** */

switch ($accion) {
	case 1: //Create (Alta)
		if ($foto != null) {
			$path = armar_Path_Y_Guardar_Imagen($foto, $legajo);
		}
		$obj = new Alumno($legajo, $nombre, $apellido, $path);
		if (Alumno::agregar($obj)) {
			echo "<h2> alumno AGREGADO </h2><br/>";
		}
		break;

	case 2: //Read (listar)
		echo Alumno::listar();
		break;

	case 3: //Update (Modificar)
		if ($foto != null) {
			$path = armar_Path_Y_Guardar_Imagen($foto, $legajo);
		}
		$obj = new Alumno($legajo, $nombre, $apellido, $path);
		if (Alumno::modificar($obj)) {
			echo "<h2> El alumno con legajo " . $obj->legajo . " se ha modificado</h2><br/>";
		} else {
			echo "<h2> El alumno con legajo " . $obj->legajo . " NO se pudo modificado o no esta en el listado.</h2><br/>";
		}
		break;

	case 4: //Delete (Borrar)
		if (Alumno::borrar($legajo)) {
			echo "<h2> El alumno con legajo " . $legajo . " se ha borrado </h2><br/>";
		} else {
			echo "<h2> El alumno con legajo " . $legajo . " NO se encuentra en el listado</h2><br/>";
		}
		break;

	case 5: // Mostrar alumno por numero de legajo

		if (Alumno::mostrarAlumno($legajo)) {
			echo "<h2> El alumno con legajo " . $legajo . " se encuentra en el listado</h2><br/>";
		} else {
			echo "<h2> El alumno con legajo " . $legajo . " NO se encuentra en el listado</h2><br/>";
		}
		break;

	case 6: // Obtener alumno
		$alumno = Alumno::obtenerAlumno($legajo);
		if ($alumno) {
			echo var_dump($alumno);
		} else {
			echo "<h2> El alumno con legajo " . $legajo . " NO se encuentra en el listado</h2><br/>";
		}
		break;

	case 7: // Redirigir
		if (Alumno::mostrarAlumno($legajo)) {
			session_start();
			$alumno = Alumno::obtenerAlumno($legajo);
			if($alumno){
				$_SESSION["legajo"] = $alumno->legajo;
				$_SESSION["nombre"] = $alumno->nombre;
				$_SESSION["apellido"] = $alumno->apellido;
				$_SESSION["foto"] = $alumno->foto;
				header("location: principal.php");	
			}
		} else {
			echo "<h2> El alumno con legajo " . $legajo . " NO se encuentra en el listado</h2><br/>";
		}
		break;

	default:
		echo "<h2> Sin ejemplo </h2>";
}


function armar_Path_Y_Guardar_Imagen(array $foto, int $legajo): string
{
	if ($foto != NULL) {
		//INDICO CUAL SERA EL DESTINO DE LA FOTO SUBIDA
		$foto_nombre = $_FILES["foto"]["name"];
		$tipoArchivo = pathinfo($foto_nombre, PATHINFO_EXTENSION);
		$path = "./fotos/" . $legajo . "." . $tipoArchivo;
		$uploadOk = TRUE;

		//PATHINFO RETORNA UN ARRAY CON INFORMACION DEL PATH
		//RETORNA : NOMBRE DEL DIRECTORIO; NOMBRE DEL ARCHIVO; EXTENSION DEL ARCHIVO

		//PATHINFO_DIRNAME - retorna solo nombre del directorio
		//PATHINFO_BASENAME - retorna solo el nombre del archivo (con la extension)
		//PATHINFO_EXTENSION - retorna solo extension
		//PATHINFO_FILENAME - retorna solo el nombre del archivo (sin la extension)

		//VERIFICO QUE EL ARCHIVO NO EXISTA
		$array_extensiones = array("jpg", "jpeg", "gif", "png");
		for ($i = 0; $i < count($array_extensiones); $i++) {
			$nombre_archivo = "./fotos/" . $legajo . "." . $array_extensiones[$i];
			if (file_exists($nombre_archivo)) {
				unlink($nombre_archivo);
				break;
			}
		}

		//VERIFICO EL TAMAÑO MAXIMO QUE PERMITO SUBIR
		if ($_FILES["foto"]["size"] > 100000) {
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
		} else {
			//MUEVO EL ARCHIVO DEL TEMPORAL AL DESTINO FINAL
			move_uploaded_file($_FILES["foto"]["tmp_name"], $path);
		}
	}
	return $path;
}
