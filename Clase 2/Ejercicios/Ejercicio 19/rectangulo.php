<?php
class Rectangulo extends FiguraGeometrica{
    public float $ladoDos;
    public float $ladoUno;

    public function __construct(float $l1, float $l2){
        parent::__construct();
        $this->ladoDos = $l2;
        $this->ladoUno = $l1;
        $this->calcularDatos();
    }

    protected function calcularDatos():void{
        $this->superficie = $this->ladoDos * $this->ladoUno;
        $this->perimetro = ($this->ladoDos * 2) + ($this->ladoUno * 2);
    }

    public function dibujar():string{
        $dibujo = "";
        for ($i=0; $i < $this->ladoDos ; $i++) { 
            for ($j=0; $j < $this->ladoUno; $j++) { 
                $dibujo = $dibujo . "*";
            }
            $dibujo = $dibujo . "<br>";
        }
        $retorno = "<span style='color:{$this->color}'{$dibujo}</span>" . "<br>";
        return $retorno;
    }

    public function ToString():string{
        return parent::ToString() .
         "Base: " . $this->ladoDos . " cm<br>" .
         "Altura: " . $this->ladoUno . " cm<br><br>" .
          $this->dibujar();
    }
}
?>