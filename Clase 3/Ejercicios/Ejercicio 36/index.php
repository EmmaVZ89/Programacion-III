<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 35</title>
</head>
<body>
    <form action="./index.php" method="get">
    <select name="destino">
        <option value="1">Rio de Janeiro</option>
        <option value="2">Punta del este</option>
        <option value="3">La Habana</option>
        <option value="4">Miami</option>
        <option value="5">Ibiza</option>
    </select>
    <br><br>
    <input type="number" name="cantidad" placeholder="Cantidad" min="1" value="1">
    <br><br>
    <select name="pago">
        <option value="1">Efectivo</option>
        <option value="2">Credito/Debito</option>
    </select>
    <br><br>
    <input type="submit" value="Ver Precio">
    </form>

    <?php
    if(count($_GET) != 0){
        $destino = $_GET["destino"];
        $pago = $_GET["pago"];
        $cantidad = (int) $_GET["cantidad"];
        $porcentaje;
        $descuento;
        $descuento_plus = 0;
        $valor;
        $total;

        if($pago == 1){
            $porcentaje = 12;
        } else {
            $porcentaje = 7;
        }

        switch ($destino) {
            case '1':
                $valor = 900;
                break;
            case '2':
                $valor = 550;
                break;
            case '3':
                $valor = 1000;
                break;
            case '4':
                $valor = 1250;
                break;
            case '5':
                $valor = 1500;
                break;
        }
        $valor_sin_descuento = $valor;
        $descuento = ($valor * $porcentaje) / 100;
        $valor = $valor - $descuento;
        if($cantidad > 2){
            $descuento_plus = ($valor * 35)/100;
            $valor = $valor - $descuento_plus;
        }
        $total = $valor * $cantidad;
        echo "<h3 style='color:green'>Precio s/ descuento: US$ " . $valor_sin_descuento . "</h3>"; 
        echo "<h3 style='color:green'>Precio c/ descuento: US$ " . $valor . "</h3>"; 
        echo "<h3 style='color:green'>Cantidad de pasajes: " . $cantidad . "</h3>";
        echo "<h3 style='color:green'>Descuento forma de pago: US$ " . $descuento . "</h3>"; 
        echo "<h3 style='color:green'>Descuento Plus por cantidad: US$ " . $descuento_plus . "</h3>";          
        echo "<h3 style='color:green'>Total: US$ " . $total . "</h3>"; 
    }
    ?>
</body>
</html>