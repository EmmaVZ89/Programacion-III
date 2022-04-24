"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function RecibirColeccionJSON() {
        let pagina = "./BACKEND/recibirColeccion.php";
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
                    span.innerText = "\n";
                    objJson.forEach((producto) => {
                        span.innerText += `Codigo: ${producto.codigo} - Nombre: ${producto.nombre} - Precio: ${producto.precio} \n`;
                        alert(`Codigo: ${producto.codigo} - Nombre: ${producto.nombre} - Precio: ${producto.precio} `);
                        console.log(`Codigo: ${producto.codigo} - Nombre: ${producto.nombre} - Precio: ${producto.precio}`);
                    });
                    console.log(objJson);
                }
            }
        };
    }
    Entidades.RecibirColeccionJSON = RecibirColeccionJSON;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map