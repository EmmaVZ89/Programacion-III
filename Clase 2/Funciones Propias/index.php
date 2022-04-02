<?php
declare(strict_types=1);

// Tipado DEBIL
function HolaMundo()
{
    echo "Hola mundo" . "<br>";
}
HolaMundo();

function SaludarDebil($nombre, $apellido)
{
    return "Hola " .  $nombre . " " . $apellido . "<br>";
}
echo SaludarDebil("Emmanuel", "Zelarayan");


// Tipado FUERTE
function HolaMundoFuerte(): void
{
    echo "Hola mundo Fuerte" . "<br>";
}
HolaMundoFuerte();

function SaludarFuerte(string $nombre, string $apellido): string
{
    return "Hola " .  $nombre . " " . $apellido . "<br>";
}
echo SaludarFuerte("Soledad", "Quiroz");

// function union_tipos(string | int $parametro): string
// {
//     if (gettype($parametro) == "string") {
//         return "Es una cadena {$parametro}<br>";
//     }
//     if (gettype($parametro) == "integer") {
//         return "Es un entero {$parametro}<br>";
//     }
// }

// echo union_tipos("Chau");
