<?php
require_once "./auto.php";
require_once "./garage.php";

$auto1 = new Auto("Ford", "red");
$auto2 = new Auto("Audi", "red");
$auto3 = new Auto("Chevrolet", "blue", 32000);
$auto4 = new Auto("Renault", "blue", 50000);
$auto5 = new Auto("Fiat", "green", 75000, new DateTime("15-04-2020"));

$auto3->agregarImpuestos(1500);
$auto4->agregarImpuestos(1500);
$auto5->agregarImpuestos(1500);

echo "Suma de precios(auto1 y auto2): $" . Auto::add($auto1, $auto2) . "<br><br>";

if($auto1->equals($auto2)){
    echo "auto1 y auto2 son iguales" . "<br><br>";
} else {
    echo "auto1 y auto2 NO son iguales" . "<br><br>";
}

if($auto1->equals($auto5)){
    echo "auto1 y auto5 son iguales" . "<br><br>";
} else {
    echo "auto1 y auto5 NO son iguales" . "<br><br>";
}

Auto::mostrarAuto($auto1);
Auto::mostrarAuto($auto3);
Auto::mostrarAuto($auto5);

$garage = new Garage("Manolo SRL", 150);
$garage->add($auto1);
$garage->add($auto2);
$garage->add($auto3);
$garage->add($auto4);
$garage->add($auto5);
$garage->mostrarGarage();

$auto6 = new Auto("BMW", "yellow", 10000, new DateTime("09-12-2018"));

$garage->add($auto1);
$garage->add($auto2);
$garage->add($auto6);

$garage->remove($auto3);

$garage->mostrarGarage();

$garage->remove($auto3);

?>