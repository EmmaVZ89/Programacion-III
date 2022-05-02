<?php
require_once("./clases/Cocinero.php");
use Zelarayan\Cocinero;

$email = isset($_POST["email"]) ? $_POST["email"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;
$exito = false;
$mensaje = "El cocinero no existe";

if($email && $clave) {
    $cocineros = Cocinero::TraerTodos();
    $cocinero = new Cocinero("", $email, $clave);
    foreach ($cocineros as $cocin) {
        if ($cocin->GetEmail() == $cocinero->GetEmail() &&
            $cocin->GetClave() == $cocinero->GetClave()) {
            $cocinero = $cocin;
            break;
        }
    }
    $mensaje_json = json_decode(Cocinero::VerificarExistencia($cocinero), true);
    if($mensaje_json["exito"]) {
        setcookie($cocinero->GetEmail()."_".$cocinero->GetEspecialidad(), date("YmdGis").". ".$mensaje_json["mensaje"], time()+3600, "/");
        $exito = true;
        $mensaje = "El cocinero se encuentra en el listado";
    }
}

if($exito) {
    $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje .". ". $mensaje_json["mensaje"]);
} else {
    $retornoJSON = array("exito" => $exito, "mensaje" => $mensaje);
}

echo json_encode($retornoJSON);