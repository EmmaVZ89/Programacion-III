namespace Calculadora {

    let xhttp : XMLHttpRequest = new XMLHttpRequest();

    export function Calcular() : void {
        let op1 = (<HTMLInputElement>document.getElementById("txtOp1")).value;    
        let op2 = (<HTMLInputElement>document.getElementById("txtOp2")).value;    
        let operacion = (<HTMLSelectElement>document.getElementById("txtOperacion")).value;

        xhttp.open("POST", "./backend/back.php", true);

        let form : FormData = new FormData();

        form.append("op1", op1);
        form.append("op2", op2);
        form.append("operacion", operacion);

        xhttp.send(form);

        xhttp.onreadystatechange = () => {
            if(xhttp.readyState == 4 && xhttp.status == 200){
                let resultado : string = xhttp.responseText;
                let span : HTMLSpanElement = <HTMLSpanElement>document.getElementById("resultado");
                span.innerText = resultado;
            }
        }

    }
}