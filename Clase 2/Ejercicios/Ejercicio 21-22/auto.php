<?php
class Auto{
    private string $color;
    private float $precio;
    private string $marca;
    private DateTime $fecha;

    public function __construct(string $marca, string $color = "black", float $precio = 0, DateTime $fecha = NULL){
        $this->marca = $marca;
        $this->color = $color;
        $this->precio = $precio;
        if(! $fecha){
            $this->fecha = new DateTime("now");
        } else {
            $this->fecha = $fecha;
        }
    }

    public function agregarImpuestos(float $num){
        $this->precio += $num;
    }

    public static function mostrarAuto(Auto $a){
        echo
        "Marca: " . $a->marca . "<br>" .
        "Color: " . $a->color . "<br>" .
        "Precio: " . $a->precio . "<br>" .
        "Fecha: " . $a->fecha->format('d-m-Y') . "<br><br>";
    }

    public function equals(Auto $a) : bool{
        $retorno = false;
        if($a->marca === $this->marca){
            $retorno = true;
        }
        return $retorno;
    }

    public static function add(Auto $a1, Auto $a2) : float{
        $retorno = 0;
        if($a1->equals($a2) && $a1->color === $a2->color){
            $retorno = $a1->precio + $a2->precio;
        }
        return $retorno;
    }

}
?>