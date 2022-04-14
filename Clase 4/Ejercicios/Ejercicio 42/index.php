<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 42</title>
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

        if (isset($_FILES["fotos"])) {
            $fotos_nombres = $_FILES["fotos"]["name"];
            $sizes = $_FILES["fotos"]["size"];
            $paths = array();
            $tiposArchivo = array();

            foreach ($fotos_nombres as $nombre) {
                $destino = "./img/" . $nombre;
                array_push($paths, $destino);
                array_push($tiposArchivo, pathinfo($destino, PATHINFO_EXTENSION));
            }

            $uploadOk = true;

            foreach ($paths as $destino) {
                if (file_exists($destino)) {
                    echo "El archivo {$destino} ya existe!!";
                    $uploadOk = false;
                    break;
                }
            }

            foreach ($sizes as $size) {
                if ($size > 90000) {
                    echo "Archivo demasiado grande.";
                    $uploadOk = false;
                    break;
                }
            }

            $tmpsNames = $_FILES["fotos"]["tmp_name"];
            $i = 0;
            foreach ($tmpsNames as $tmpName) {
                $esImagen = getimagesize($tmpName);
                if ($esImagen) {
                    if ($tiposArchivo[$i] != "jpg" && $tiposArchivo[$i] != "jpeg") {
                        echo "Solo son permitidas imagenes con extension JPG y JPEG";
                        $uploadOk = false;
                        break;
                    }
                }
                $i++;
            }

            if ($uploadOk === false) {
                echo "<br/>NO SE PUDIERON SUBIR LOS ARCHIVO.";
            } else {
                for ($i = 0; $i < count($tmpsNames); $i++) {
                    if (move_uploaded_file($tmpsNames[$i], $paths[$i])) {
                        echo
                        "<tr>
                            <td>
                                <a href='./index.php?img=" . $paths[$i] . "'><img width='100px' src='" . $paths[$i] . "'></a>
                            </td>
                        </tr>";
                    } else {
                        echo "<br/>Lamentablemente ocurri&oacute; un error y no se pudo subir el archivo " . basename($tmpsNames[$i]) . ".";
                    }
                }
            }
        }
        ?>
    </table>

    <form action="./index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fotos[]" multiple accept=".jpg, .jpeg" />
        <br />
        <input type="submit" value="Subir Imagen" />
    </form>

</body>

</html>