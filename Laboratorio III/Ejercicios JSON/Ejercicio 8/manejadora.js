"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function LeerArchivoJsonYCargarInputs() {
        let pagina = "./backend/traerAuto.php";
        xhttp.open("POST", pagina, true);
        xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhttp.send(null);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let span = (document.getElementById("respuesta"));
                    let respuesta = xhttp.responseText;
                    let autoJson = JSON.parse(respuesta);
                    let autoStr = `\nId: ${autoJson.Id}
          Marca: ${autoJson.Marca}
          Precio: ${autoJson.Precio}
          Color: ${autoJson.Color}
          Modelo: ${autoJson.Modelo}`;
                    span.innerText = autoStr;
                    console.log(autoStr);
                    console.log(autoJson);
                    (document.getElementById("txtId")).value = autoJson.Id;
                    (document.getElementById("txtMarca")).value = autoJson.Marca;
                    (document.getElementById("txtPrecio")).value = autoJson.Precio;
                    (document.getElementById("txtColor")).value = autoJson.Color;
                    (document.getElementById("txtModelo")).value = autoJson.Modelo;
                }
            }
        };
    }
    Entidades.LeerArchivoJsonYCargarInputs = LeerArchivoJsonYCargarInputs;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map