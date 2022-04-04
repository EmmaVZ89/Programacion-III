<?php
require_once("./alumno.php");

use Zelarayan\Alumno;

//RECUPERO TODOS LOS VALORES (POST)
$accion = isset($_REQUEST["accion"]) ? (int) $_REQUEST["accion"] : 0;
$legajo = isset($_REQUEST["legajo"]) ? (int) $_REQUEST["legajo"] : 0;
$nombre = isset($_REQUEST["nombre"]) ? $_REQUEST["nombre"] : NULL;
$apellido = isset($_REQUEST["apellido"]) ? $_REQUEST["apellido"] : NULL;

//****************************************** */
//CRUD - SOBRE ARCHIVOS
//****************************************** */

switch($accion)
{
	case 1://Create (Alta)

		$obj = new Alumno($legajo, $nombre, $apellido);

		if(Alumno::agregar($obj)){

			echo "<h2> alumno AGREGADO </h2><br/>";	
		}

		break;

	case 2://Read (listar)

		echo Alumno::listar();

		break;

	case 3://Update (Modificar)

		$obj = new Alumno($legajo, $nombre, $apellido);

		if(Alumno::modificar($obj))
		{
			echo "<h2> El alumno con legajo ".$obj->legajo." se ha modificado</h2><br/>";			
		}
		else
		{
			echo "<h2> El alumno con legajo ".$obj->legajo." NO se encuentra en el listado</h2><br/>";
		}

		break;

	case 4://Delete (Borrar)

		if(Alumno::borrar($legajo))
		{
			echo "<h2> El alumno con legajo ". $legajo ." se ha borrado </h2><br/>";			
		}
		else 
		{
			echo "<h2> El alumno con legajo " . $legajo ." NO se encuentra en el listado</h2><br/>";
		}

		break;
	
	case 5:// Mostrar alumno por numero de legajo

		if(Alumno::mostrarAlumno($legajo))
		{
			echo "<h2> El alumno con legajo " . $legajo ." se encuentra en el listado</h2><br/>";
		}
		else
		{
			echo "<h2> El alumno con legajo " . $legajo ." NO se encuentra en el listado</h2><br/>";
		}

		break;
				
	default:
		echo "<h2> Sin ejemplo </h2>";
}