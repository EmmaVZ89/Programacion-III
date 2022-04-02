<?php
require_once "./auto.php";
class Garage {
    private string $razonSocial;
    private float $precioPorHora;
    private array $autos;

    public function __construct(string $razonSocial, float $precioPorHora = 0){
        $this->razonSocial = $razonSocial;
        $this->precioPorHora = $precioPorHora;
        $this->autos = array();
    }

    public function mostrarGarage() {
        echo "<br><br>" .
        "Razon social: " . $this->razonSocial . "<br>" .
        "Precio por hora: " . $this->precioPorHora . "<br><br>" .
        "Listado de autos: " . "<br><br>";
        if(count($this->autos) > 0){
            for ($i=0; $i < count($this->autos); $i++) { 
                echo Auto::mostrarAuto($this->autos[$i]);
            }    
        }
        else {
            echo "... GARAGE VACIO ...<br><br>";
        }
    }

    public function equals(Garage $g, Auto $a):bool {
        $retorno = false;
        for ($i=0; $i < count($g->autos); $i++) { 
            if($g->autos[$i]->equals($a)){ 
                $retorno = true;
                break;
            }    
        }
        return $retorno;
    }

    public function add(Auto $a) {
        if(! $this->equals($this, $a)){
            array_push($this->autos, $a);
        } else {
            echo "El auto ya existe en el garage!!!" . "<br>";
        }
    }

    public function remove(Auto $a) {
        if( $this->equals($this, $a)){
            $index = -1;
            foreach ($this->autos as $key => $value) {
                if($a->equals($value)){
                    $index = $key;
                    break;
                }
            }
            if($index !== -1){
                array_splice($this->autos, $index, 1);
            }
        } else {
            echo "El auto NO se encuentra en el garage!!!" . "<br>";
        }
    }
}

?>