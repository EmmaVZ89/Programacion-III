"use strict";
var Entidades;
(function (Entidades) {
    let xhttp = new XMLHttpRequest();
    function CargarComboBox() {
        let codigoPais = (document.getElementById("cmbPaises")).value;
        let pagina = "./backend/administrarCiudades.php";
        xhttp.open("POST", pagina, true);
        // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        let form = new FormData();
        form.append("accion", "traerCiudades");
        form.append("codigoPais", codigoPais);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            var DONE = 4;
            var OK = 200;
            if (xhttp.readyState === DONE) {
                if (xhttp.status === OK) {
                    let respuesta = xhttp.responseText;
                    let ciudadesJson = JSON.parse(respuesta);
                    const selectCiudades = (document.getElementById("cmbCiudades"));
                    selectCiudades.innerHTML = "";
                    ciudadesJson.forEach((ciudad) => {
                        const option = document.createElement("option");
                        let text = document.createTextNode(ciudad.Ciudad.toUpperCase());
                        option.appendChild(text);
                        selectCiudades.appendChild(option);
                    });
                }
            }
        };
    }
    Entidades.CargarComboBox = CargarComboBox;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=manejadora.js.map