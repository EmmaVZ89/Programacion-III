<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Principal</title>
</head>

<body>
  <?php
  session_start();
  require_once __DIR__ . '/vendor/autoload.php';
  require_once("./accesoDatos.php");
  require_once("./alumno.php");

  use Zelarayan\Alumno;
  use Zelarayan\AccesoDatos;

  $legajo = 3;

  // if (
  //   isset($_SESSION["legajo"]) && isset($_SESSION["nombre"]) &&
  //   isset($_SESSION["apellido"]) && isset($_SESSION["foto"])
  // ) {
  //   $legajo = $_SESSION["legajo"];
  //   $nombre = $_SESSION["nombre"];
  //   $apellido = $_SESSION["apellido"];
  //   $foto = $_SESSION["foto"];

  //   echo "<h1>Legajo: " . $legajo . "</h1>";
  //   echo "<h2>Nombre: " . $nombre . "</h2>";
  //   echo "<h2>Apellido: " . $apellido . "</h2>";
  //   echo "<img src='" . $foto . "' width=150px><br><br>";

  $alumnos = Alumno::listar();

  $tabla =
    "<table>" .
    "<thead>" .
    "<th>Legajo</th>" .
    "<th>Nombre</th>" .
    "<th>Apellido</th>" .
    "<th>Foto</th>" .
    "</thead>" .
    "<tbody>";

  foreach ($alumnos as $alumno) {
    $tabla .= "<tr>";
    foreach ($alumno as $key => $value) {
      if ($key == "foto") {
        $tabla .= "<td><img src='" . $value . "' width=25px></td>";
      } else {
        $tabla .= "<td>" . $value . "</td>";
      }
    }
    $tabla .= "</tr>";
  }

  $tabla .= "</tbody>" .
    "</table> <br>";
  echo $tabla;

  echo
  '<form action="./principal.php" method="post">' .
    '<input type="hidden" name="pass" value="' . $legajo . '">' .
    '<select name="opcion"> ' .
    '<option value="seleccione" selected disabled>Seleccione</option>' .
    '<option value="visualizacion">Visualización</option>' .
    '<option value="descarga">Descarga</option>' .
    '</select> <br><br>' .
    '<input type="submit" value="Ver/Descargar PDF">' .
    '</form>';
  // }

  if (isset($_POST["opcion"]) && isset($_POST["pass"])) {
    $opcion = $_POST["opcion"];
    $pass = $_POST["pass"];
    
    header('content-type:application/pdf');
    $mpdf = new \Mpdf\Mpdf([
      'orientation' => 'P',
      'pagenumPrefix' => 'Página nro. ',
      'pagenumSuffix' => ' - ',
      'nbpgPrefix' => ' de ',
      'nbpgSuffix' => ' páginas'
    ]); //P-> vertical; L-> horizontal

    $mpdf->SetProtection(array(), $pass, 'mipass');

    $mpdf->SetHeader('Zelarayan Emmanuel||{PAGENO}{nbpg}');
    //alineado izquierda | centro | alineado derecha
    $mpdf->SetFooter('|{DATE j-m-Y}|');

    $alumnos = Alumno::listar();
    $tabla =
      "<table>" .
      "<thead>" .
      "<th>Legajo</th>" .
      "<th>Nombre</th>" .
      "<th>Apellido</th>" .
      "<th>Foto</th>" .
      "</thead>" .
      "<tbody>";
    foreach ($alumnos as $alumno) {
      $tabla .= "<tr>";
      foreach ($alumno as $key => $value) {
        if ($key == "foto") {
          $tabla .= "<td><img src='" . $value . "' width=25px></td>";
        } else {
          $tabla .= "<td>" . $value . "</td>";
        }
      }
      $tabla .= "</tr>";
    }
    $tabla .= "</tbody>" .
      "</table>";


    $mpdf->WriteHTML("<h3>Listado de Alumnos</h3>");
    $mpdf->WriteHTML("<br>");
    $mpdf->WriteHTML($tabla);

    if ($opcion == "visualizacion") {
      $mpdf->Output('alumnos.pdf', 'I');
    } else if ($opcion == "descarga") {
      $mpdf->Output('alumnos.pdf', 'D');
    }
  }
  // else {
  //   header("location: nexo.php");
  // }
  // session_destroy();
  // http://localhost/Programacion-III/Clase%204/ejercicio%20clase/nexo.php?accion=7&legajo=1000
  ?>
</body>
<a href=""></a>

</html>