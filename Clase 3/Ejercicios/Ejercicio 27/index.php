<?php
    $nombre_archivo = 
    date("Y")."_".
    date("m")."_".
    date("d")."_".
    date("G")."_".
    date("i")."_".
    date("s");
    $texto_archivo = "";
	$path_origen = "./archivo.txt";
	$path_destino = "./misArchivos/" . $nombre_archivo . ".txt";

	$ar = fopen("./archivo.txt", "r");
	while(!feof($ar))
    {
        $linea = fgets($ar);
		if($linea != ""){
			echo $linea;
			$texto_archivo .= $linea;
		}
    }
	$texto_archivo = strrev($texto_archivo);
	fclose($ar);

	$ar = fopen($path_destino, "w");
	$cant = 0;
	$cant = fwrite($ar, $texto_archivo);
	fclose($ar);	

?>