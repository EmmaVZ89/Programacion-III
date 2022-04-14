<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 40</title>
</head>

<body>
    <table>
        <tr>
            <td>
                <a href="./index.php?img=img/1.jpg"><img width="100px" src="./img/1.jpg"></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="./index.php?img=img/2.jpg"><img width="100px" src="./img/2.jpg"></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="./index.php?img=img/3.jpg"><img width="100px" src="./img/3.jpg"></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="./index.php?img=img/4.jpg"><img width="100px" src="./img/4.jpg"></a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="./index.php?img=img/5.jpg"><img width="100px" src="./img/5.jpg"></a>
            </td>
        </tr>
    </table>

    <?php
    if (isset($_GET["img"])) {
        session_start();
        $_SESSION["img"] = $_GET["img"];
        header("location: pagina1.php");
    }
    ?>

</body>

</html>