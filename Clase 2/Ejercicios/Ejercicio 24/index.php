<?php
require_once "./operario.php";
require_once "./fabrica.php";

$operario1 = new Operario(1000, "Emmanuel", "Zelarayan", 10000);
$operario2 = new Operario(1001, "Sol", "Quiroz", 20000);
$operario3 = new Operario(1002, "Luna", "Perez", 30000);
$operario4 = new Operario(1000, "Emmanuel", "Zelarayan", 50000);
$operario5 = new Operario(1003, "Lautaro", "Diaz", 40000);
$operario6 = new Operario(1004, "Kevin", "Solo", 20000);
$operario7 = new Operario(1005, "Julian", "Piggi", 15000);

$operario1->setAumentarSalario(20);
$operario2->setAumentarSalario(30);

$fabrica = new Fabrica("Ledesma SACI");

$fabrica->add($operario1);
$fabrica->add($operario2);
$fabrica->add($operario3);
$fabrica->add($operario4);
$fabrica->add($operario5);
$fabrica->add($operario6);
$fabrica->add($operario7);

echo $fabrica->mostrar();
Fabrica::mostrarCosto($fabrica);

$fabrica->remove($operario5);
$fabrica->remove($operario7);
echo $fabrica->mostrar();
?>