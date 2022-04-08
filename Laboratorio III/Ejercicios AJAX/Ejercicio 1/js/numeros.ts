namespace Entidad {
    let xhttp : XMLHttpRequest = new XMLHttpRequest();

    export function ContarImpares() {
        let numero: string = (<HTMLInputElement>document.getElementById("txtNumero")).value;
        xhttp.open("POST", "./backend/back.php", true);
    
        let form: FormData = new FormData();
    
        form.append("numero", numero);
    
        xhttp.send(form);
    
        xhttp.onreadystatechange = () => {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            let input : HTMLInputElement = (<HTMLInputElement>document.getElementById("txtNumeroImp"));
            input.value = xhttp.responseText;
          }
        };
      }
    
}