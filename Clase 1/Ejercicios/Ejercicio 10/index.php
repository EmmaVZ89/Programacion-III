<?php
$numerosImpares = array();
$i = 0;
$num;

while($i < 10){
    $num = rand(0, 20);
    if($num % 2 !== 0){
        $numerosImpares[$i] = $num;
        $i++;
    }
}

for ($i=0; $i < count($numerosImpares) ; $i++) { 
    echo $numerosImpares[$i] . "<br>";
}

echo "<br><br>";

$k = 0;
while($k < count($numerosImpares)){
    echo $numerosImpares[$k] . "<br>";
    $k++;
}

echo "<br><br>";

foreach ($numerosImpares as $item) {
    echo $item . "<br>";
}

?>