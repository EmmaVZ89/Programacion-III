namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function CargarComboBox(): void {
    let codigoPais = (<HTMLSelectElement>(document.getElementById("cmbPaises"))).value;
    
    let pagina = "./backend/administrarCiudades.php";

    xhttp.open("POST", pagina, true);
    // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let form: FormData = new FormData();
    form.append("accion", "traerCiudades");
    form.append("codigoPais", codigoPais);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;
          let ciudadesJson = JSON.parse(respuesta);
          
          const selectCiudades = <HTMLSelectElement>(document.getElementById("cmbCiudades"));
          selectCiudades.innerHTML = "";
          ciudadesJson.forEach((ciudad:any) => {
            const option = document.createElement("option");
            let text = document.createTextNode(ciudad.Ciudad.toUpperCase());
            option.appendChild(text);
            selectCiudades.appendChild(option);
          });

        }
      }
    };
  }
}
