<?php
namespace Zelarayan;

class Cocinero
{
    private string $especialidad;
    private string $email;
    private string $clave;

    public function __construct(
        string $especialidad = "",
        string $email = "",
        string $clave = ""
    ) {
        $this->especialidad = $especialidad;
        $this->email = $email;
        $this->clave = $clave;
    }

    public function GetEspecialidad() : string {
        return $this->especialidad;
    }

    public function GetEmail():string {
        return $this->email;
    }

    public function GetClave():string {
        return $this->clave;
    }

    public function ToJSON(): string
    {
        $retorno = array(
        "especialidad" => $this->especialidad,
        "email" => $this->email,
        "clave" => $this->clave);
        return json_encode($retorno);
    }


    public function GuardarEnArchivo(): string
    {
        $exito = false;
        $mensaje = "No se pudo guardar el cocinero";
        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/cocinero.json", "a"); //A - append
        //ESCRIBO EN EL ARCHIVO CON FORMATO: $this->ToJSON()
        $cant = fwrite($ar, "{$this->ToJSON()},\r\n");
        if ($cant > 0) {
            $exito = true;
            $mensaje = "cocinero guardado con exito";
        }
        //CIERRO EL ARCHIVO
        fclose($ar);

        $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

        return json_encode($retornoJSON);
    }

    public static function TraerTodos(): array
    {
        $array_cocineros = array();

        //ABRO EL ARCHIVO
        $ar = fopen("./archivos/cocinero.json", "r");
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
                $obj =  json_decode($array_contenido[$i], true);
                $esp = $obj["especialidad"];
                $email = $obj["email"];
                $clave = $obj["clave"];
                $cocinero = new Cocinero($esp, $email, $clave);
                array_push($array_cocineros, $cocinero);
            }
        }

        return $array_cocineros;
    }

    public static function VerificarExistencia(Cocinero $cocinero) : string {
        $cocineros = Cocinero::TraerTodos();
        $array_especialidades = array();
        $cantidadEspecialidad = 0;
        $flagMax = true;
        $max = 0;
        $exito = false;
        $mensaje = "";

        foreach ($cocineros as $cocin) {
            array_push($array_especialidades, $cocin->GetEspecialidad());

            if ($cocin->GetEmail() == $cocinero->GetEmail() &&
                $cocin->GetClave() == $cocinero->GetClave()) {
                $exito = true;
            }

            if ($cocin->GetEspecialidad() == $cocinero->GetEspecialidad()) {
                $cantidadEspecialidad++;
            }
        }

        $array_asoc_especialidades = array_count_values($array_especialidades);

        $cantidadCocinero = 0;
        $cocineroMayor = "";

        foreach ($array_asoc_especialidades as $key => $item) {
            $cantidadCocinero = $item;

            if ($flagMax || $cantidadCocinero > $max) {
                $max = $cantidadCocinero;
                $cocineroMayor = $key;
                $flagMax = false;
            }
        }

        if ($exito) {
            $mensaje = "Hay un total de {$cantidadEspecialidad} cocineros con la misma especialidad";
        } else {
            $mensaje = "La especialidad con mas apariciones es {$cocineroMayor} con un total de {$max}";
        }

        $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);

        return json_encode($retornoJSON);
    }


}


// http://localhost/Programacion-III/Clase 6 Modelo PP