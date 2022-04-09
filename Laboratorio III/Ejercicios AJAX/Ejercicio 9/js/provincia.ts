namespace Provincia {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  cargarProvincias();

  function cargarProvincias() {
    let selectProvincia: HTMLSelectElement = <HTMLSelectElement>(
      document.getElementById("txtProvincias")
    );

    xhttp.open("POST", "./backend/back.php", true);
    xhttp.send(null);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        selectProvincia.innerHTML = xhttp.responseText;
      }
    };
  }

  export function cargarCiudades() {
    let selectCiudades: HTMLSelectElement = <HTMLSelectElement>(
      document.getElementById("txtCiudades")
    );

    let selectProvincia: HTMLSelectElement = <HTMLSelectElement>(
      document.getElementById("txtProvincias")
    );

    let provincia = selectProvincia.value;

    xhttp.open("POST", "./backend/back.php", true);

    let form: FormData = new FormData();
    form.append("provincia", provincia);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        selectCiudades.innerHTML = xhttp.responseText;
      }
    };
  }
}
