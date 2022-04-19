<?php
namespace Zelarayan;
use PDO;

class Alumno
{

	public int $legajo;
	public string $nombre;
	public string $apellido;
	public string $foto;

	public function __construct(int $legajo=0, string $nombre="", string $apellido="", string $foto="")
	{
		$this->legajo = $legajo;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->foto = $foto;
	}

	public static function agregar(Alumno $alumno): bool
	{
		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

		$consulta = $accesoDatos->retornarConsulta("INSERT INTO alumnos (legajo, nombre, apellido, foto) "
			. "VALUES(:legajo, :nombre, :apellido, :foto)");
		
		// $consulta->bindValue(":id", 1000, PDO::PARAM_INT);
		$consulta->bindValue(":legajo", $alumno->legajo, PDO::PARAM_INT);
		$consulta->bindValue(":nombre", $alumno->nombre, PDO::PARAM_STR);
		$consulta->bindValue(":apellido", $alumno->apellido, PDO::PARAM_STR);
		$consulta->bindValue(":foto", $alumno->foto, PDO::PARAM_STR);

		$retorno = $consulta->execute();

		return $retorno;
	}

	public static function listar()
	{
		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
		$consulta = $accesoDatos->retornarConsulta("SELECT legajo, nombre, apellido, foto FROM alumnos");
		$consulta->execute();
		$consulta->setFetchMode(PDO::FETCH_INTO, new Alumno);

		return $consulta;
	}

	public function listarAlumno() {
		return "{$this->legajo} - {$this->apellido} - {$this->nombre} - {$this->foto}";
	}

	public static function modificar(Alumno $alumno): bool
	{
		$retorno = false;

		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();

		$cadena = "UPDATE alumnos SET nombre = :nombre, apellido = :apellido, foto = :foto WHERE legajo = :legajo";
		$consulta = $accesoDatos->retornarConsulta($cadena);

		$consulta->bindValue(":legajo", $alumno->legajo, PDO::PARAM_INT);
		$consulta->bindValue(":nombre", $alumno->nombre, PDO::PARAM_STR);
		$consulta->bindValue(":apellido", $alumno->apellido, PDO::PARAM_STR);
		$consulta->bindValue(":foto", $alumno->foto, PDO::PARAM_STR);

		$consultaOK = $consulta->execute();

		if($consultaOK && Alumno::validarAlumno($alumno->legajo)){
			$retorno = true;
		}

		return $retorno;
	}

	public static function borrar(int $legajo): bool
	{
		$retorno = false;
		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
		$consulta = $accesoDatos->retornarConsulta("DELETE FROM alumnos WHERE legajo = :legajo");
		$consulta->bindValue(":legajo", $legajo, PDO::PARAM_INT);

		
		if(Alumno::validarAlumno($legajo)){
			$pathImg = Alumno::obtenerAlumno($legajo)->foto;
			if($consulta->execute()) {
				$retorno = true;
				unlink($pathImg);
			}
		}

		return $retorno;
	}

	public static function validarAlumno(int $legajo): bool
	{
		$retorno = false;

		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
		$consulta = $accesoDatos->retornarConsulta("SELECT legajo, nombre, apellido, foto FROM alumnos WHERE legajo = :legajo");
		$consulta->bindValue(":legajo", $legajo, PDO::PARAM_INT);
		$consulta->execute();

		// $array_alumno = $consulta->fetch();
		if($consulta->fetch()) {
			$retorno = true;
		}
		
		return $retorno;
	}

	public static function obtenerAlumno(int $legajo)
	{
		$alumno = null;

		$accesoDatos = AccesoDatos::obtenerObjetoAccesoDatos();
		$consulta = $accesoDatos->retornarConsulta("SELECT legajo, nombre, apellido, foto FROM alumnos WHERE legajo = :legajo");
		$consulta->bindValue(":legajo", $legajo, PDO::PARAM_INT);
		$consulta->execute();

		$array_alumno = $consulta->fetch();
		if(count($array_alumno) > 0) {
			$leg = $array_alumno[0];
			$nombre = $array_alumno[1];
			$apellido = $array_alumno[2];
			$foto = $array_alumno[3];

			$alumno = new Alumno($leg, $nombre, $apellido, $foto);
		}
		
		return $alumno;
	}
}
