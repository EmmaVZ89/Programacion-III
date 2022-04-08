"use strict";
var Entidad;
(function (Entidad) {
    let xhttp = new XMLHttpRequest();
    function ContarImpares() {
        let numero = document.getElementById("txtNumero").value;
        xhttp.open("POST", "./backend/back.php", true);
        let form = new FormData();
        form.append("numero", numero);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let input = document.getElementById("txtNumeroImp");
                input.value = xhttp.responseText;
            }
        };
    }
    Entidad.ContarImpares = ContarImpares;
})(Entidad || (Entidad = {}));
//# sourceMappingURL=numeros.js.map