<?php
class Triangulo extends FiguraGeometrica{
    public float $altura;
    public float $base;

    public function __construct(float $b, float $h){
        parent::__construct();
        $this->base = $b;
        $this->altura = $h;
        $this->calcularDatos();
    }

    protected function calcularDatos():void{
        $this->superficie = ($this->base * $this->altura) / 2;
        $this->perimetro = $this->base + ($this->altura*2);
    }

    public function dibujar():string{
        $dibujo = "";
        $espacios = $this->altura;
        for ($i = 1; $i <= $this->altura; $i++){
            $espacios--;
            for ($k = 0; $k < $espacios; $k++){
                $dibujo = $dibujo . " . ";
            }
            if ($i == 1){
                $dibujo = $dibujo . "*";
            }
            else{
                for ($j = 1; $j <= $i * 2 - 1; $j++){
                    $dibujo = $dibujo . "*";
                }
            }
            for ($l = 0; $l < $espacios; $l++){
                $dibujo = $dibujo . " . ";
            }
            $dibujo = $dibujo . "<br>";
        }
        echo $dibujo;
        $retorno = "<span style='color:{$this->color}'{$dibujo}</span>" . "<br>";
        echo $retorno;
        return $retorno;
    }

    public function ToString():string{
        return parent::ToString() .
         "Base: " . $this->base . " cm<br>" .
         "Altura: " . $this->altura . " cm<br><br>" .
          $this->dibujar();
    }
}

?>