<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 38</title>
</head>
<body>
<form action="./index.php" method="get">
    <select name="comida">
        <option value="1">Milanesa</option>
        <option value="2">Pizza Grande</option>
        <option value="3">Empanada</option>
        <option value="4">Gaseosa</option>
        <option value="5">Ensalada</option>
    </select>
    <br><br>
    <input type="number" name="cantidad" placeholder="Cantidad" min="1" value="1">
    <br><br>
    <input type="submit" value="Calcular Total">
    </form>

    <?php
    if(count($_GET) != 0){
        $comida = $_GET["comida"];
        $cantidad = (int) $_GET["cantidad"];
        $porcentaje = 0;
        $descuento = 0;
        $valor;
        $total;
        $total_sin_descuento;

        switch ($comida) {
            case '1':
                $valor = 250;
                break;
            case '2':
                $valor = 500;
                break;
            case '3':
                $valor = 100;
                break;
            case '4':
                $valor = 150;
                break;
            case '5':
                $valor = 250;
                break;
        }

        $total = $valor * $cantidad;
        $total_sin_descuento = $total;
        if($total >= 300 && $total <= 550){
            $porcentaje = 10;
        } else if($total > 550){
            $porcentaje = 20;
        }

        $descuento = ($total * $porcentaje) / 100;
        $total = $total - $descuento;

        echo "<h3 style='color:green'>Total s/ descuento: US$ " . $total_sin_descuento . "</h3>";
        echo "<h3 style='color:green'>Descuento(".$porcentaje."%): US$ " . $descuento . "</h3>";  
        echo "<h3 style='color:green'>Total c/ descuento: US$ " . $total . "</h3>"; 
    }
    ?>

</body>
</html>