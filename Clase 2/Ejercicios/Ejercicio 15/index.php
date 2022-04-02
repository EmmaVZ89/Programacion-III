<?php

for ($i=1; $i < 5 ; $i++) { 
    echo potencia($i) . "<br>";
}

function potencia($numero){
    return pow($numero, 2);
}

?>