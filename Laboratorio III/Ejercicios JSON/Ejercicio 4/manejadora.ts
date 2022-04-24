namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();
  let arrayProductos: Array<any> = [];

  export function EnviarColeccionJSON2(): void {
    //CREO UN OBJETO JSON
    let codigo: string = (<HTMLInputElement>(
      document.getElementById("txtCodigo")
    )).value;
    let nombre: string = (<HTMLInputElement>(
      document.getElementById("txtNombre")
    )).value;
    let precio: number = parseInt(
      (<HTMLInputElement>document.getElementById("txtPrecio")).value
    );
    let producto = { codigoBarra: codigo, nombre: nombre, precio: precio };
    arrayProductos.push(producto);

    if (arrayProductos.length === 3) {
      let pagina = "./BACKEND/mostrarColeccionJson.php";

      let params: string = "productos="+ JSON.stringify(arrayProductos);
      xhttp.open("POST", pagina, true);
      xhttp.setRequestHeader(
        "content-type",
        "application/x-www-form-urlencoded"
      );
      xhttp.send(params);

      xhttp.onreadystatechange = () => {
        var DONE = 4;
        var OK = 200;
        if (xhttp.readyState === DONE) {
          if (xhttp.status === OK) {
            let respuesta: string = xhttp.responseText;
            let span: HTMLSpanElement = <HTMLSpanElement>(
              document.getElementById("respuesta")
            );
            span.innerHTML = respuesta;
          }
        }
      };
    } else {
      (<HTMLInputElement>document.getElementById("txtCodigo")).value = "";
      (<HTMLInputElement>document.getElementById("txtNombre")).value = "";
      (<HTMLInputElement>document.getElementById("txtPrecio")).value = "";
    }
  }
}
