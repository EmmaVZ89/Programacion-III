namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function LeerArchivoJsonYCargarInputs(): void {
    let pagina = "./backend/traerAuto.php";

    xhttp.open("POST", pagina, true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send(null);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let span: HTMLSpanElement = <HTMLSpanElement>(
            document.getElementById("respuesta")
          );
          let respuesta: string = xhttp.responseText;
          let autoJson = JSON.parse(respuesta);
          let autoStr = `\nId: ${autoJson.Id}
          Marca: ${autoJson.Marca}
          Precio: ${autoJson.Precio}
          Color: ${autoJson.Color}
          Modelo: ${autoJson.Modelo}`;
          span.innerText = autoStr;
          console.log(autoStr);
          console.log(autoJson);

          (<HTMLInputElement>(document.getElementById("txtId"))).value = autoJson.Id;
          (<HTMLInputElement>(document.getElementById("txtMarca"))).value = autoJson.Marca;
          (<HTMLInputElement>(document.getElementById("txtPrecio"))).value = autoJson.Precio;
          (<HTMLInputElement>(document.getElementById("txtColor"))).value = autoJson.Color;
          (<HTMLInputElement>(document.getElementById("txtModelo"))).value = autoJson.Modelo;
        }
      }
    };
  }
}
