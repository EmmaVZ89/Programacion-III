<?php
    $ar = fopen("./misArchivos/palabras.txt", "r");
    $uno = 0;
    $dos = 0;
    $tres = 0;
    $cuatro = 0;
    $cuatro_mas = 0;

    while(!feof($ar))
    {
        $linea = fgets($ar);
        $palabras = explode(" ", $linea);
        for ($i=0; $i < count($palabras); $i++) { 
            $palabras[$i] = trim($palabras[$i]);
            switch (strlen($palabras[$i])) {
                case 1:
                    $uno++;
                    break;
                case 2:
                    $dos++;
                    break;
                case 3:
                    $tres ++;
                    break;
                case 4:
                    $cuatro++;
                    break;
                default:
                    $cuatro_mas++;
                    break;
            }
        }
    }

    echo "Una letra: " . $uno . "<br>";
    echo "Dos letras: " . $dos. "<br>";
    echo "Tres letras: " . $tres . "<br>";
    echo "Cuatro letras: " . $cuatro . "<br>";
    echo "Mas de cuatro letras: " . $cuatro_mas . "<br>";

    fclose($ar);

?>