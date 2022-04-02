<?php
require_once "./operario.php";
class Fabrica {
    private int $cantMaxOperarios;
    private array $operarios;
    private string $razonSocial;

    public function __construct(string $rs){
        $this->razonSocial = $rs;
        $this->cantMaxOperarios = 5;
        $this->operarios = array();
    }

    public function add(Operario $op) : bool {
        $retorno = false;
        if(count($this->operarios) < $this->cantMaxOperarios){
            if(! $this->equals($this, $op)){
                array_push($this->operarios, $op);
                $retorno = true;
            }
        }
        return $retorno;
    }

    public function equals(Fabrica $fb, Operario $op) : bool {
        $retorno = false;
        foreach ($fb->operarios as $operario) {
            if($op->equals($operario)){
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    public function mostrar() : string {
        return "Empresa: " . $this->razonSocial . "<br>" .
        "Cantidad maxima de operarios: " . $this->cantMaxOperarios . "<br>" . 
        "Lista de operarios: " . "<br>" .
        $this->mostrarOperarios();
    }

    public static function mostrarCosto(Fabrica $fb) {
        echo "Costo total: $" . $fb->retornarCostos() . "<br><br>";
    }

    private function mostrarOperarios() : string {
        $ops = "";
        foreach ($this->operarios as $key => $value) {
            $ops = $ops . $value->mostrar();
        }
        return $ops;
    }

    public function remove(Operario $op) : bool {
        $retorno = false;
        $index = -1;
        foreach ($this->operarios as $key => $value) {
            if($op->equals($value)){
                $index = $key;
                break;
            }
        }
        if($index !== -1){
            array_splice($this->operarios, $index, 1);
            $retorno = true;
        } 
        return $retorno;
    }

    private function retornarCostos() : float {
        $retorno = 0;
        foreach ($this->operarios as $op) {
            $retorno += $op->getSalario();
        }
        return $retorno;
    }
}
?>