"use strict";
var Calculadora;
(function (Calculadora) {
    let xhttp = new XMLHttpRequest();
    function Calcular() {
        let op1 = document.getElementById("txtOp1").value;
        let op2 = document.getElementById("txtOp2").value;
        let operacion = document.getElementById("txtOperacion").value;
        xhttp.open("POST", "./backend/back.php", true);
        let form = new FormData();
        form.append("op1", op1);
        form.append("op2", op2);
        form.append("operacion", operacion);
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let resultado = xhttp.responseText;
                let span = document.getElementById("resultado");
                span.innerText = resultado;
            }
        };
    }
    Calculadora.Calcular = Calcular;
})(Calculadora || (Calculadora = {}));
//# sourceMappingURL=calculadora.js.map