namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();
  export function EnviarJSON(): void {
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
    let pagina = "./BACKEND/mostrarJson.php";

    let params: string = "producto=" + JSON.stringify(producto);
    xhttp.open("POST", pagina, true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
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
  }
}
