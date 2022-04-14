<?php
namespace Zelarayan;

class Alumno{

	public int $legajo;
	public string $nombre;
	public string $apellido;
	public string $foto;

	public function __construct(int $legajo, string $nombre, string $apellido, string $foto)
	{
		$this->legajo = $legajo;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->foto = $foto;
	}

	public static function agregar(Alumno $obj) : bool {
		$retorno = false;
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "a");//A - append
		//ESCRIBO EN EL ARCHIVO CON FORMATO: legajo-apellido-nombre-foto
		$cant = fwrite($ar, "{$obj->legajo}-{$obj->apellido}-{$obj->nombre}-{$obj->foto}\r\n");
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
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$retorno .= fgets($ar);		
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
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			//http://www.w3schools.com/php/func_string_explode.asp
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if(trim($array_linea[0]) != ""){
				//RECUPERO LOS CAMPOS
				$legajo_archivo = trim($array_linea[0]);
				$apellido_archivo = trim($array_linea[1]);
				$nombre_archivo = trim($array_linea[2]);
				$foto_archivo = trim($array_linea[3]);
				
				if ($legajo_archivo == $obj->legajo && $obj->apellido != "" &&
				$obj->nombre != "" && $obj->foto != "") {
					array_push($alumnos, "{$obj->legajo}-{$obj->apellido}-{$obj->nombre}-{$obj->foto}\r\n");
					$alumno_modificacion = true;
				}
				else{
					array_push($alumnos, "{$legajo_archivo}-{$apellido_archivo}-{$nombre_archivo}-{$foto_archivo}\r\n");
				}
			}
		}

		//CIERRO EL ARCHIVO
		fclose($ar);
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "w");
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
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
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
				$foto_archivo = trim($array_linea[3]);
				if ($legajo_archivo == $legajo) {
					$alumno_eliminado = true;
					continue;
				}
				array_push($alumnos, "{$legajo_archivo}-{$apellido_archivo}-{$nombre_archivo}-{$foto_archivo}\r\n");
			}
		}

		//CIERRO EL ARCHIVO
		fclose($ar);
		$cant = 0;

		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "w");

		//ESCRIBO EN EL ARCHIVO
		foreach($alumnos AS $item){
			$cant = fwrite($ar, $item);
		}

		if($cant >= 0)
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
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
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

	public static function obtenerAlumno(int $legajo) {
		$alumno = null;
		//ABRO EL ARCHIVO
		$ar = fopen("./archivos/alumnos_foto.txt", "r");
		//LEO LINEA X LINEA DEL ARCHIVO 
		while(!feof($ar))
		{
			$linea = fgets($ar);
			$array_linea = explode("-", $linea);
			$array_linea[0] = trim($array_linea[0]);
			if(trim($array_linea[0]) != ""){
				$legajo_archivo = trim($array_linea[0]);
				$apellido_archivo = trim($array_linea[1]);
				$nombre_archivo = trim($array_linea[2]);
				$foto_archivo = trim($array_linea[3]);
				
				if ($legajo_archivo == $legajo) {
					$alumno = new Alumno($legajo_archivo, $nombre_archivo, $apellido_archivo, $foto_archivo);
					break;
				}
			}
		}

		//CIERRO EL ARCHIVO
		fclose($ar);

		return $alumno;
	}

}