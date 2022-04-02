<?php
class Pasajero {
    private string $nombre;
    private string $apellido;
    private string $dni;
    public bool $esPlus;
    
    public function __construct(string $nombre, string $apellido, string $dni, bool $esPlus){
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->esPlus = $esPlus;
    }
    
    public function equals(Pasajero $p) : bool {
        $retorno = false;
        if($this->dni === $p->dni){
            $retorno = true;
        }
        return $retorno;
    }    

    public function getInfoPasajero() : string {
        return $this->nombre . " - " . $this->apellido . " - " . $this->dni . " - " . $this->esPlus . "<br>";
    }

    public static function mostrarPasajero(Pasajero $p) {
        echo $p->getInfoPasajero();
    }
}

?>