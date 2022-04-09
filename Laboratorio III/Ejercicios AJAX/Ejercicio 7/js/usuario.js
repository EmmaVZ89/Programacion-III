"use strict";
var UsuarioAlternativo;
(function (UsuarioAlternativo) {
    let xhttp = new XMLHttpRequest();
    function Verificar() {
        let usuario = (document.getElementById("txtUsuario")).value;
        AdministrarGif(true);
        xhttp.open("POST", "./backend/comprabarDisponibilidad.php", true);
        let form = new FormData();
        form.append("usuario", usuario);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    if (respuesta == "") {
                        alert(`El nombre de usuario '${usuario}' ${respuesta} esta disponible.`);
                    }
                    else {
                        alert(`El nombre de usuario '${usuario}' NO esta disponible.`);
                        let ul = (document.getElementById("nombresAlternativos"));
                        ul.innerHTML = respuesta;
                    }
                    AdministrarGif(false);
                }
                else {
                    AdministrarGif(false);
                }
            }
        };
    }
    UsuarioAlternativo.Verificar = Verificar;
    function CargarNombreAlternativo() {
        let ul = (document.getElementById("nombresAlternativos"));
        ul.addEventListener("click", manejador);
    }
    UsuarioAlternativo.CargarNombreAlternativo = CargarNombreAlternativo;
    function manejador(evento) {
        if (evento.target instanceof HTMLAnchorElement) {
            let id = evento.target.id;
            let nombre = (document.getElementById("txtUsuario"));
            nombre.value = id;
        }
    }
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
})(UsuarioAlternativo || (UsuarioAlternativo = {}));
//# sourceMappingURL=usuario.js.map