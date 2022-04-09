"use strict";
var Usuario;
(function (Usuario) {
    let xhttp = new XMLHttpRequest();
    function Verificar() {
        let usuario = (document.getElementById("txtUsuario")).value;
        AdministrarGif(true);
        xhttp.open("POST", "./backend/comprabarDisponibilidad.php", true);
        // let form : FormData = new FormData();
        // form.append("usuario", usuario);
        xhttp.send(null);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    alert(`El nombre de usuario '${usuario}' ${respuesta} esta disponible.`);
                    AdministrarGif(false);
                }
                else {
                    AdministrarGif(false);
                }
            }
        };
    }
    Usuario.Verificar = Verificar;
    function AdministrarGif(mostrar) {
        var gif = "./assets/load.gif";
        let div = document.getElementById("divGif");
        let img = document.getElementById("imgGif");
        if (mostrar) {
            div.style.display = "block";
            div.style.top = "50%";
            div.style.left = "45%";
            img.src = gif;
        }
        if (!mostrar) {
            div.style.display = "none";
            img.src = "";
        }
    }
})(Usuario || (Usuario = {}));
//# sourceMappingURL=usuario.js.map