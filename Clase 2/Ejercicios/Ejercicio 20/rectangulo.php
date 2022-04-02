<?php
class Rectangulo{
    private Punto $vertice1;
    private Punto $vertice2;
    private Punto $vertice3;
    private Punto $vertice4;
    public float $area;
    public int $base;
    public int $altura;
    public float $perimetro;

    public function __construct(Punto $v1, Punto $v3){
        $this->vertice1 = new Punto($v1->getX(), $v1->getY());
        $this->vertice2 = new Punto($v3->getX(), $v1->getY());
        $this->vertice3 = new Punto($v3->getX(), $v3->getY());
        $this->vertice4 = new Punto($v1->getX(), $v3->getY());
        $this->base = abs($this->vertice1->getX() - $this->vertice3->getX());
        $this->altura = abs($this->vertice1->getY() - $this->vertice3->getY());
        $this->area = $this->base * $this->altura;
        $this->perimetro = ($this->base + $this->altura) * 2;
    }

    public function dibujar():string{
        $dibujo = "";
        for ($i=0; $i < $this->altura ; $i++) { 
            for ($j=0; $j < $this->base; $j++) { 
                $dibujo = $dibujo . "*";
            }
            $dibujo = $dibujo . "<br>";
        }
        $retorno = 
        "Vertice 1: " . $this->vertice1->getX() . " - " . $this->vertice1->getY() . "<br>" .
        "Vertice 2: " . $this->vertice2->getX() . " - " . $this->vertice2->getY() . "<br>" .
        "Vertice 3: " . $this->vertice3->getX() . " - " . $this->vertice3->getY() . "<br>" .
        "Vertice 4: " . $this->vertice4->getX() . " - " . $this->vertice4->getY() . "<br>" .
        "Base: " . $this->base . " cm<br>" .
        "Altura: " . $this->altura . " cm<br>" .
        "Area: " . $this->area . " cm<br>" .
        "Perimetro: " . $this->perimetro . " cm<br><br>" . $dibujo;
        return $retorno;
    }

}
?>