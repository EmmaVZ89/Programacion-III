<?php
class Enigma {
    public static function encriptar(string $mensaje, string $path) : bool {
        $retorno = false;
        $mensaje_encriptado = "";
        
        for ($i=0; $i < strlen($mensaje); $i++) { 
            $caracter_ascii = ord($mensaje[$i]) + 200;
            $caracter_char = chr($caracter_ascii);
            $mensaje_encriptado .= $caracter_char;
        }
        
        $ar = fopen($path, "w");
        $cant = 0;
        $cant = fwrite($ar, $mensaje_encriptado);

        if($cant > 0){
            $retorno = true;
        }

        fclose($ar);	

        return $retorno;
    }

    public static function desencriptar(string $path) : string {
        $retorno = false;
        $mensaje_desencriptado = "";
        $mensaje_encriptado = "";

        $ar = fopen($path, "r");
        while(!feof($ar))
        {
            $linea = fgets($ar);
            if($linea != ""){
                $mensaje_encriptado .= $linea;
            }
        }
        fclose($ar);
    
        for ($i=0; $i < strlen($mensaje_encriptado); $i++) { 
            $caracter_ascii = ord($mensaje_encriptado[$i]) - 200;
            $caracter_char = chr($caracter_ascii);
            $mensaje_desencriptado .= $caracter_char;
        }

        return $mensaje_desencriptado;
    }
}
?>