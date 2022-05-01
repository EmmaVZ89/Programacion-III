<?php 
require_once("./clases/Usuario.php");
use Zelarayan\Usuario;
use Zelarayan\AccesoDatos;

$array_usuarios = Usuario::TraerTodos();

for ($i=0; $i < count($array_usuarios); $i++) { 
    $usuario = $array_usuarios[$i];
        echo $usuario->ToString() . "<br>";    
}
