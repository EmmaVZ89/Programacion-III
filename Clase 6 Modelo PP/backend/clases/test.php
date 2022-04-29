<?php
require_once("./accesoDatos.php");
require_once("./Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

// $usuarios = Usuario::TraerTodos();
// foreach ($usuarios as $usuario) {
//     var_dump($usuario);
//     print("<br>");
// }

$usuario = Usuario::TraerUno(array("correo"=>"emple@emple.com", "clave"=>"emple123"));
var_dump($usuario);