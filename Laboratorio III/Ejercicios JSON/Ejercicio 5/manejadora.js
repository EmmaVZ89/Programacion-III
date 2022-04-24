"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function RecibirJSON() {
        let pagina = "./BACKEND/recibirJson.php";
        xhttp.open("POST", pagina, true);
        xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhttp.send(null);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let span = (document.getElementById("respuesta"));
                    let objJson = JSON.parse(xhttp.responseText);
                    span.innerText = `Codigo: ${objJson.codigo} - Nombre: ${objJson.nombre} - Precio: ${objJson.precio}`;
                    alert(objJson);
                    console.log(objJson);
                }
            }
        };
    }
    Entidades.RecibirJSON = RecibirJSON;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map