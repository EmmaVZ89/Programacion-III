<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 34</title>
</head>
<body>
    <form action="./index.php" method="get">
        <input type="checkbox" name="dia" value="1" checked> Dia
        <input type="checkbox" name="mes" value="2"> Mes
        <input type="checkbox" name="anio" value="3"> Año
        <br><br>
        <input type="submit" value="Mostrar Fecha">
        <br><br>
    </form>

    <?php
    if(count($_GET) != 0){
        $array = $_GET;
        $dia = 0;
        $mes = 0;
        $anio = 0;
        foreach ($array as $key => $value) {
            if($key === "dia"){
                $dia = $value;
            }
            if($key === "mes"){
                $mes = $value;
            }
            if($key === "anio"){
                $anio = $value;
            }
        }
 
        if($dia){
            echo "Dia: " . date("d") . "<br>";
        }
        if($mes){
            echo "Mes: " . date("m") . "<br>";
        }
        if($anio){
            echo "Año: " . date("Y") . "<br>";
        }
    }
    ?>
</body>
</html>