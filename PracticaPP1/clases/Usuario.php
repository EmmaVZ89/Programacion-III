<?php
namespace Zelarayan;
// require_once("./clases/IBM.php");
// use PDO;
// use stdClass;

class Usuario
{
    private string $email;
    private string $clave;

    public function __construct(
        string $email = "",
        string $clave = ""
    ) {
        $this->email = $email;
        $this->clave = $clave;
    }

    public function GetEmail():string {
        return $this->email;
    }

    public function GetClave():string {
        return $this->clave;
    }

    public function ToString(): string
    {
        return "{$this->email} - {$this->clave}";
    }

    public function GuardarEnArchivo(): string
    {
        $mensaje = "No se pudo guardar el Usuario";
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/usuarios.txt", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToString()},\r\n");
        if ($cant > 0) {
            $mensaje = "Usuario Guardado con exito";
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        return $mensaje;
    }

    public static function TraerTodos(): array
    {
        $array_usuarios = array();

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/usuarios.txt", "r");
        $contenido = "";
        //LEO LINEA X LINEA DEL ARCHIVO 
        while (!feof($ar)) {
            $contenido .= fgets($ar);
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        $array_contenido = explode(",\r\n", $contenido);

        for ($i = 0; $i < count($array_contenido); $i++) {
            if ($array_contenido[$i] != "") {
                $usuario_array = explode("-", $array_contenido[$i]);
                $email = trim($usuario_array[0]);
                $clave = trim($usuario_array[1]);
                $usuario = new Usuario($email, $clave);
                array_push($array_usuarios, $usuario);
            }
        }

        return $array_usuarios;
    }

    public static function VerificarExistencia(Usuario $usuario) : bool {
        $retorno = false;
		$usuarios = Usuario::TraerTodos();

        for ($i=0; $i < count($usuarios) ; $i++) { 
            if($usuarios[$i]->GetEmail() == $usuario->GetEmail() &&
            $usuarios[$i]->GetClave() == $usuario->GetClave()) {
                $retorno = true;
                break;
            }
        }
		return $retorno;
    }


}


// http://localhost/Programacion-III/Clase 6 Modelo PP