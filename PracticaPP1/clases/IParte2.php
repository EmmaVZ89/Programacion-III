<?php
namespace Zelarayan;

interface IParte2 {
    public function Agregar():bool;
    public static function Traer():array;
    public function CalcularIVA():float;
    public function Verificar(array $televisores):bool;
}

?>