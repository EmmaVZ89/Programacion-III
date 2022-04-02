<?php
abstract class FiguraGeometrica {
    protected string $color;
    protected float $perimetro;
    protected float $superficie;

    public function __construct(){
        $this->color = "blue";
        $this->perimetro = 0;
        $this->superficie = 0;
    }

    protected abstract function calcularDatos();
    public abstract function dibujar() : string;

    public function getColor() : string {
        return $this->color;
    }

    public function setColor(string $color) : void {
        $this->color = $color;
    }

    public function ToString() : string {
        return "Color: " . $this->color . "<br>" .
        "Perimetro: " . $this->perimetro . " cm<br>" .
        "Superficie: " . $this->superficie . " cm<br>";
    }
}
?>