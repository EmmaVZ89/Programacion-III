"use strict";
var Provincia;
(function (Provincia) {
    let xhttp = new XMLHttpRequest();
    cargarProvincias();
    function cargarProvincias() {
        let selectProvincia = (document.getElementById("txtProvincias"));
        xhttp.open("POST", "./backend/back.php", true);
        xhttp.send(null);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                selectProvincia.innerHTML = xhttp.responseText;
            }
        };
    }
    function cargarCiudades() {
        let selectCiudades = (document.getElementById("txtCiudades"));
        let selectProvincia = (document.getElementById("txtProvincias"));
        let provincia = selectProvincia.value;
        xhttp.open("POST", "./backend/back.php", true);
        let form = new FormData();
        form.append("provincia", provincia);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                selectCiudades.innerHTML = xhttp.responseText;
            }
        };
    }
    Provincia.cargarCiudades = cargarCiudades;
})(Provincia || (Provincia = {}));
//# sourceMappingURL=provincia.js.map