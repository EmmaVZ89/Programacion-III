<?php

class Test
{
    private string $cadena; // private
    public int $entero; // publico
    var float $flotante; // publico
    public string $solo_lectura;

    // CONSTRUCTOR
    public function __construct()
    {
        $this->cadena = $this->formatearCadena("valor inicial");
        $this->entero = 1;
        $this->flotante = 0.0;
        $this->solo_lectura = "solo para leer";
    }

    // METODOS PUBLICO DE INSTANCIA
    public function mostrar()
    {
        return $this->cadena . " - " . $this->entero . " - " . $this->flotante . " - " . $this->solo_lectura;
    }

    // METODO PRIVADO DE INSTANCIA
    private function formatearCadena($cadena)
    {
        return ucwords($cadena);
    }

    // METODO DE CLASE
    public static function mostrarTest(Test $obj)
    {
        return $obj->mostrar();
    }
}
