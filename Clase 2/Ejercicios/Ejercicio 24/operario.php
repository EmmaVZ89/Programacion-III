<?php
class Operario {
    private string $nombre;
    private string $apellido;
    private float $salario;
    private int $legajo;
    
    public function __construct(int $legajo, string $nombre, string $apellido, float $salario) {
        $this->legajo = $legajo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->salario = $salario;
    }
    
    public function equals(Operario $op) : bool {
        $retorno = false;
        if($this->nombre === $op->nombre &&
        $this->apellido === $op->apellido &&
        $this->legajo === $op->legajo){
            $retorno = true;
        }
        return $retorno;
    }

    public function getNombreApellido() : string {
        return $this->nombre . ", " . $this->apellido;
    }

    public function getSalario() : float {
        return $this->salario;
    }

    public function mostrar() : string {
        return $this->getNombreApellido() . " - " . 
        $this->salario . " - " . $this->legajo . "<br>";
    }

    // public static function mostrar(Operario $op) : string {
    //     return $op->mostrar();
    // }

    public function setAumentarSalario(float $aumento){
        $this->salario *= (1 + ($aumento/100));
    }
}
?>