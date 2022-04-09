<?php

$noticia = isset($_REQUEST["noticia"]) ? (int) $_REQUEST["noticia"] : 0;

$array_noticias = array("Noticia 1", "Noticia 2", "Noticia 3","Noticia 4","Noticia 5","Noticia 6",
"Noticia 7","Noticia 8","Noticia 9","Noticia 10","Noticia 11","Noticia 12","Noticia 13","Noticia 14");

$fecha = 
date("d")."/".
date("m")."/".
date("Y")."__Hora: ".
date("G").":".
date("i").":".
date("s");

if($noticia < count($array_noticias) && $noticia >= 0){
    echo $array_noticias[$noticia] . "<br>" . " Fecha: " . $fecha;
} else {
    echo "";
}

?>