<?php
require_once "./pasajero.php";
class Vuelo {
    private DateTime $fecha;
    private string $empresa;
    private float $precio;
    private array $listaDePasajeros;
    private int $cantMaxima;

    public function getCantMaxima() : int {
        return $this->cantMaxima;
    }

    public function __construct(string $empresa, float $precio, int $cantMaxima = 0){
        $this->empresa = $empresa;
        $this->precio = $precio;
        $this->cantMaxima = $cantMaxima;
        $this->listaDePasajeros = array();
        $this->fecha = new DateTime("now");
    }

    public function getInfo() : string {
        $retorno = 
        "Fecha: " . $this->fecha->format('d-m-Y') . "<br>" .
        "Empresa: " . $this->empresa . "<br>" .
        "Precio: " . $this->precio . "<br>" . 
        "Cantidad Maxima: " . $this->cantMaxima . "<br>" . 
        "Lista de Pasajeros: " . "<br>";
        if(count($this->listaDePasajeros) > 0){
            foreach ($this->listaDePasajeros as $pasajero) {
                $retorno = $retorno . $pasajero->getInfoPasajero();
            }    
        } else {
            $retorno = $retorno . " ... LISTA VACIA ... ";
        }
        $retorno = $retorno . "<br><br>";
        return $retorno;
    }

    public function agregarPasajero(Pasajero $p):bool{
        $retorno = false;
        if(count($this->listaDePasajeros) < $this->cantMaxima) {
            $esta = false;
            foreach ($this->listaDePasajeros as $pasajero) {
                if($p->equals($pasajero)){
                    $esta = true;
                    break;
                }
            }
            if(! $esta){
                array_push($this->listaDePasajeros, $p);
                $retorno = true;
            }
        }
        return $retorno;
    }

    public function mostrarVuelo() {
        echo $this->getInfo();
    }

    public static function add(Vuelo $v1, Vuelo $v2) : float{
        $retorno = 0;
        foreach ($v1->listaDePasajeros as $pasajero) {
            if($pasajero->esPlus){
                $retorno += ($v1->precio * 0.80);
            } else {
                $retorno += $v1->precio;
            }
        }
        foreach ($v2->listaDePasajeros as $pasajero) {
            if($pasajero->esPlus){
                $retorno += ($v2->precio * 0.80);
            } else {
                $retorno += $v2->precio;
            }
        }
        return $retorno;
    }

    public static function remove(Vuelo $v, Pasajero $p) : Vuelo {
        $index = -1;
        foreach ($v->listaDePasajeros as $key => $value) {
            if($p->equals($value)){
                $index = $key;
                break;
            }
        }
        if($index !== -1){
            array_splice($v->listaDePasajeros, $index, 1);
        } else {
            echo "El pasajero NO se encuentra en el vuelo!!!" . "<br><br>";
        }
        return $v;
    }

}

?>