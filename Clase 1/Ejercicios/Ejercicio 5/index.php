<?php
$a = 5;
$b = 1;
$c = 5;

$aBool = $a < $b && $a > $c || $a < $c && $a > $b;
$bBool = $b < $a && $b > $c || $b < $c && $b > $a;
$cBool = $c < $a && $c > $b || $c < $b && $c > $a;

if($aBool){
    echo $a;
}

if($bBool){
    echo $b;
}

if($cBool){
    echo $c;
}

if(! $aBool && ! $bBool && ! $cBool){
    echo "No hay valor del medio";
}

?>