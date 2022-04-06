<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 39</title>
</head>
<body>
    <form action="./index.php" method="get">
        <input type="number" name="numero" placeholder="Numero">
        <br><br>
        <input type="submit" value="Ver Info">
        <br><br>
    </form>

    <?php
    if(count($_GET) != 0){
        $numero = $_GET["numero"];
        $cantidad_cifras = 0;
        $suma_impares = 0;
        $suma_pares = 0;
        $suma_total = 0;
        $divisores = array();
        $num_int = (int)$numero;

        for ($i=0; $i < strlen($numero) ; $i++) { 
            $cantidad_cifras++;
            $num_aux = (int)$numero[$i];
            $suma_total += $num_aux;
            if($num_aux % 2 === 0){
                $suma_pares += $num_aux;
            } else {
                $suma_impares += $num_aux;
            }
        }

        for ($i=1; $i <= $num_int ; $i++) { 
            if($num_int % $i === 0){
                array_push($divisores, $i);
            }
        }

        echo "<h3 style='color:green'>Numero: " . $numero . "</h3>";
        echo "<h3 style='color:green'>Cantidad de cifras: " . $cantidad_cifras . "</h3>";
        echo "<h3 style='color:green'>Suma de pares: " . $suma_pares . "</h3>";
        echo "<h3 style='color:green'>Suma de impares: " . $suma_impares . "</h3>";
        echo "<h3 style='color:green'>Suma total: " . $suma_total . "</h3>";
        echo "<h3 style='color:green'>Lista de divisores: "; 
        for ($i=0; $i < count($divisores) ; $i++) { 
            echo $divisores[$i] . ", ";
        }
        echo "</h3>";
    }
    ?>
</body>
</html>