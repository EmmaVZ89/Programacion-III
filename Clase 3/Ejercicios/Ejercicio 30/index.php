<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 30</title>
</head>
<body>
    <form action="./index.php" method="get">
        <label for="">Filas: </label>
        <select name="filas">
            <?php
            for ($i=1; $i <= 50; $i++) { 
                echo "<option value='".$i."'>". $i . "</option>";
            }
            ?>
        </select>
        <label for="">Columnas: </label>
        <select name="columnas">
            <?php
            for ($i=1; $i <= 50; $i++) { 
                echo "<option value='".$i."'>". $i . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Generar Tabla">
    </form>

    <table>
    <?php
    if(count($_GET) != 0){
        $filas = $_GET["filas"];
        $columnas = $_GET["columnas"];
        for ($i=0; $i < $filas ; $i++) {
            echo "<tr>";
            for ($j=1; $j <= $columnas; $j++) { 
                echo "<td>" . $j . "</td>";
            }
            echo "</tr>";
        }
    }
    ?>
    </table>

</body>
</html>