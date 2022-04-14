<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 44</title>
</head>

<body>
    <form action="./index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivos[]" multiple>
        <br><br>
        <input type="submit" value="Subir Archivos">
        <br><br>
    </form>

    <?php
    if (isset($_FILES["archivos"])) {
        $nombres_archivos = $_FILES["archivos"]["name"];
        $sizes = $_FILES["archivos"]["size"];
        $tmpsNames = $_FILES["archivos"]["tmp_name"];
        $extensiones = array();
        $nombres_archivos_sin_extension = array();
        $paths = array();
        $max_size = 500000;
        $uploadOK = true;

        foreach ($nombres_archivos as $nombre) {
            $destino = "./uploads/" . $nombre;
            array_push($paths, $destino);
            array_push($extensiones, pathinfo($destino, PATHINFO_EXTENSION));
            array_push($nombres_archivos_sin_extension, pathinfo($destino, PATHINFO_FILENAME));
        }

        foreach ($paths as $destino) {
            if (file_exists($destino)) {
                $nombre = pathinfo($destino, PATHINFO_BASENAME);
                echo "El archivo '{$nombre}' ya existe!";
                $uploadOK = false;
                break;
            }
        }

        for ($i = 0; $i < count($extensiones); $i++) {
            $max_size = 500000;
            if ($extensiones[$i] == "doc" || $extensiones[$i] == "docx") {
                $max_size = 60000;
            } else if ($extensiones[$i] == "jpg" || $extensiones[$i] == "jpeg" || $extensiones[$i] == "gif") {
                $max_size = 300000;
                $esImagen = getimagesize($tmpsNames[$i]);
                if ($esImagen) {
                    if ($extensiones[$i] != "jpg" && $extensiones[$i] != "jpeg" && $extensiones[$i] != "gif") {
                        echo "Solo son permitidas imagenes con extension JPG, JPEG o GIF.";
                        $uploadOk = false;
                    }
                }
            }

            if ($sizes[$i] > $max_size) {
                echo "Archivo {$nombres_archivos_sin_extension[$i]} demasiado grande";
                $uploadOK = false;
                break;
            }

            if ($uploadOK === false) {
                break;
            }
        }

        if ($uploadOK === false) {
            echo "<br/>NO SE PUDIERON SUBIR LOS ARCHIVO.";
        } else {
            for ($i = 0; $i < count($tmpsNames); $i++) {
                if (move_uploaded_file($tmpsNames[$i], $paths[$i])) {
                    $size_kb = $sizes[$i] / 1000;
                    echo "Archivo subido con exito!<br>";
                    echo "Nombre: {$nombres_archivos_sin_extension[$i]}<br>";
                    echo "Extension: {$extensiones[$i]}<br>";
                    echo "Tamaño: {$size_kb} kb<br><br>";
                } else {
                    echo "Ocurrio un error en la subida del archivo!<br><br>";
                }
            }
        }
    }
    ?>

</body>

</html>