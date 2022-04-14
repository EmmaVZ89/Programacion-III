<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 41</title>
</head>

<body>
    <table>
        <?php
        $dir = opendir("./img");
        // Leo todos los ficheros de la carpeta
        while ($elemento = readdir($dir)) {
            // Tratamos los elementos . y .. que tienen todas las carpetas
            if ($elemento != "." && $elemento != "..") {
                // Si es una carpeta
                if (is_dir("./img" . $elemento)) {
                    // Muestro la carpeta
                    echo "<p><strong>CARPETA: " . $elemento . "</strong></p>";
                    // Si es un fichero
                } else {
                    // Muestro el fichero
                    echo
                    "<tr>
                        <td>
                            <a href='./index.php?img=./img/" . $elemento . "'><img width='100px' src='./img/" . $elemento . "'></a>
                        </td>
                    </tr>";
                }
            }
        }

        if (isset($_GET["img"])) {
            session_start();
            $_SESSION["img"] = $_GET["img"];
            header("location: pagina1.php");
        }

        if (isset($_FILES["foto"])) {
            $foto_nombre = $_FILES["foto"]["name"];
            $nombre_sin_extension = pathinfo($foto_nombre, PATHINFO_FILENAME);
            $tipoArchivo = pathinfo($foto_nombre, PATHINFO_EXTENSION);
            $path = "./img/" . $foto_nombre;
            $uploadOk = TRUE;

            $array_extensiones = array("jpg", "jpeg", "gif", "png");
            for ($i = 0; $i < count($array_extensiones); $i++) {
                $nombre_archivo = "./img/" . $nombre_sin_extension . "." . $array_extensiones[$i];
                if (file_exists($nombre_archivo)) {
                    echo "El archivo ya existe. Verifique!!!";
                    $uploadOk = false;
                    break;
                }
            }

            if ($_FILES["foto"]["size"] > 100000) {
                echo "Archivo demasiado grande.";
                $uploadOk = false;
            }

            $esImagen = getimagesize($_FILES["foto"]["tmp_name"]);

            if ($esImagen) {
                if (
                    $tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
                    && $tipoArchivo != "png"
                ) {
                    echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
                    $uploadOk = FALSE;
                }
            }

            if ($uploadOk === FALSE) {
                echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
            } else {
                move_uploaded_file($_FILES["foto"]["tmp_name"], $path);
                echo
                "<tr>
                    <td>
                        <a href='./index.php?img=" . $path . "'><img width='100px' src='" . $path . "'></a>
                    </td>
                </tr>";
            }
        }
        ?>
    </table>

    <form action="./index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="foto" />
        <br />
        <input type="submit" value="Subir Imagen" />
    </form>

</body>

</html>