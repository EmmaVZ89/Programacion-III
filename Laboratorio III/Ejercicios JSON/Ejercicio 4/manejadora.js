"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    let arrayProductos = [];
    function EnviarColeccionJSON2() {
        //CREO UN OBJETO JSON
        let codigo = (document.getElementById("txtCodigo")).value;
        let nombre = (document.getElementById("txtNombre")).value;
        let precio = parseInt(document.getElementById("txtPrecio").value);
        let producto = { codigoBarra: codigo, nombre: nombre, precio: precio };
        arrayProductos.push(producto);
        if (arrayProductos.length === 3) {
            let pagina = "./BACKEND/mostrarColeccionJson.php";
            let params = "productos=" + JSON.stringify(arrayProductos);
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
        else {
            document.getElementById("txtCodigo").value = "";
            document.getElementById("txtNombre").value = "";
            document.getElementById("txtPrecio").value = "";
        }
    }
    Entidades.EnviarColeccionJSON2 = EnviarColeccionJSON2;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map