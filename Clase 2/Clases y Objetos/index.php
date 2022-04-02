<?php

// class NombreClase{
//     // Atributos
//     // Metodos
//     //[modificador] $nombreAtributo;
//     //[modificador] function nombreMetodo([parametros]){ ... }
// }

// class NombreClase
// {
//     //Atributos
//     private $attr1;
//     protected $attr2;
//     var $attr3;
//     public static $attr4;

//     //Constructor
//     public function __construct()
//     {
//         //codigo
//     }

//     //Metodos
//     private function func1($param)
//     {
//         // codigo
//     }
//     protected function func2()
//     {
//         // codigo
//     }
//     public function func3()
//     {
//         // codigo
//     }
//     public static function func4()
//     {
//         // codigo
//     }
// }

require_once "./test.php";
require_once "./i_mostrable.php";
require_once "./otro_test.php";
require_once "./clase_abstracta.php";
require_once "./clase.php";

// CREO UN OBJETO
// $obj = new Test();

// // UTILIZO METODO DE INSTANCIA
// echo $obj->mostrar();
// echo "<br>";

// // ACCEDO A LOS ATRIBUTOS
// $obj->entero = 3;
// $obj->flotante = 5.43;
// echo $obj->solo_lectura  . "<br>";

// echo Test::mostrarTest($obj);

// *********************************************************************************************

// $otroObj = new OtroTest();

//UTILIZO METODO DE INSTANCIA
// echo $otroObj->mostrar();
// echo "<br/>";

// //UTILIZO METODO DE CLASE
// echo OtroTest::mostrarTest($otroObj);
// echo "<br/>";

// //ACCEDO A ATRUBUTO ESTATICO
// OtroTest::$att = "valor pasado";
// echo OtroTest::$att;

// //UTILIZO METODO DE INTERFACE
// $otroObj->mostrarMensaje();

// *********************************************************************************************

//--------------------------------------------------------------------------------//
$oobj = new Clase("valor padre", "valor hijo");

echo $oobj->getAtributo();
echo "<br/>";
echo $oobj->otroAtributo;
echo "<br/>";

echo $oobj->metodoAbstracto();
//--------------------------------------------------------------------------------//
