<?php
namespace Zelarayan;

class Alumno{

	public int $legajo;
	public string $nombre;
	public string $apellido;

	public function __construct(int $legajo, string $nombre, string $apellido)
	{
		$this->legajo = $legajo;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
	}

	public static function agregar(Alumno $obj) : bool {
		$retorno = false;
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "a");//A - append
		//ESCRIBO EN EL ARCHIVO CON FORMATO: legajo-nombre-apellido
		$cant = fwrite($ar, "{$obj->legajo} - {$obj->apellido} - {$obj->nombre}\r\n");
		if($cant > 0)
		{
			$retorno = true;			
		}
		//CIERRO EL ARCHIVO
		fclose($ar);
		return $retorno;
	}

	public static function listar() : string {
		$retorno = "";
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$retorno .= fgets($ar) . "<br>";		
		}
		//CIERRO EL ARCHIVO
		fclose($ar);
		return $retorno;
	}

	public static function modificar(Alumno $obj) : bool {
		$retorno = false;
		$alumno_modificacion = false;
		$alumnos = array();
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			//http://www.w3schools.com/php/func_string_explode.asp
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				//RECUPERO LOS CAMPOS
				$legajo_archivo = trim($array_linea[0]);
				$apellido_archivo = trim($array_linea[1]);
				$nombre_archivo = trim($array_linea[2]);

				if ($legajo_archivo == $obj->legajo) {
					array_push($alumnos, "{$legajo_archivo} - {$obj->apellido} - {$obj->nombre}\r\n");
					$alumno_modificacion = true;
				}
				else{
					array_push($alumnos, "{$legajo_archivo} - {$apellido_archivo} - {$nombre_archivo}\r\n");
				}
			}
		}

		//CIERRO EL ARCHIVO
		fclose($ar);
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "w");
		$cant = 0;
		//ESCRIBO EN EL ARCHIVO
		foreach($alumnos AS $item){
			$cant = fwrite($ar, $item);
		}
		if($cant > 0)
		{
			$retorno = $alumno_modificacion;			
		}
		//CIERRO EL ARCHIVO
		fclose($ar);
		return $retorno;
	}

	public static function borrar(int $legajo) : bool {
		$retorno = false;
		$alumno_eliminado = false;
		$alumnos = array();
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			//http://www.w3schools.com/php/func_string_explode.asp
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				//RECUPERO LOS CAMPOS
				$legajo_archivo = trim($array_linea[0]);
				$apellido_archivo = trim($array_linea[1]);
				$nombre_archivo = trim($array_linea[2]);
				if ($legajo_archivo == $legajo) {
					$alumno_eliminado = true;
					continue;
				}
				array_push($alumnos, "{$legajo_archivo} - {$apellido_archivo} - {$nombre_archivo}\r\n");
			}
		}

		//CIERRO EL ARCHIVO
		fclose($ar);
		$cant = 0;

		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "w");

		//ESCRIBO EN EL ARCHIVO
		foreach($alumnos AS $item){
			$cant = fwrite($ar, $item);
		}

		if($cant > 0)
		{
			$retorno = $alumno_eliminado;			
		}

		//CIERRO EL ARCHIVO
		fclose($ar);

		return $retorno;
	}

	public static function mostrarAlumno(int $legajo) : bool {
		$retorno = false;
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if($array_linea[0] != ""){
				//RECUPERO LOS CAMPOS
				$legajo_archivo = trim($array_linea[0]);
				if($legajo == $legajo_archivo){
					$retorno = true;
					break;
				}
			}
		}
		//CIERRO EL ARCHIVO
		fclose($ar);
		return $retorno;
	}

}