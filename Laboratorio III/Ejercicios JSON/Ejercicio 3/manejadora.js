"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function EnviarJSON() {
        //CREO UN OBJETO JSON
        let codigo = (document.getElementById("txtCodigo")).value;
        let nombre = (document.getElementById("txtNombre")).value;
        let precio = parseInt(document.getElementById("txtPrecio").value);
        let producto = { codigoBarra: codigo, nombre: nombre, precio: precio };
        let pagina = "./BACKEND/mostrarJson.php";
        let params = "producto=" + JSON.stringify(producto);
        xhttp.open("POST", pagina, true);
        xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhttp.send(params);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let span = (document.getElementById("respuesta"));
                    span.innerHTML = respuesta;
                }
            }
        };
    }
    Entidades.EnviarJSON = EnviarJSON;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map