<?php
    $respuesta = rand(0, 1);
    $espera = rand(0, 6);
    sleep($espera);

    if($respuesta){
        echo "SI";
    } else {
        echo "NO";
    }
?>