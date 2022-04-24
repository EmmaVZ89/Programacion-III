namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function LeerArchivoJsonCiudades2(): void {
    let pagina = "./backend/administrarCiudades.php";

    xhttp.open("POST", pagina, true);
    // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let form : FormData = new FormData();
    form.append("accion", "traerCiudades");

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;
          let ciudadesJson = JSON.parse(respuesta);
          console.log(ciudadesJson);

          const contenerdorTabla: HTMLDivElement = <HTMLDivElement>(
            document.getElementById("contenedorTabla")
          );
          contenerdorTabla.innerHTML = "";

          const tabla: HTMLTableElement = document.createElement("table");
          const tbody = document.createElement("tbody");

          const thead = document.createElement("thead");
          for (const key in ciudadesJson[0]) {
            if(key !== "coord") {
              const th = document.createElement("th");
              let text = document.createTextNode(key.toUpperCase());
              th.appendChild(text);
              thead.appendChild(th);  
            } else {
              for (const k in ciudadesJson[0][key]) {
                const th = document.createElement("th");
                let text = document.createTextNode(k.toUpperCase());
                th.appendChild(text);
                thead.appendChild(th);    
              }
            }
          }

          ciudadesJson.forEach((ciudad: any) => {
            const tr = document.createElement("tr");
            for (const key in ciudad) {
              if(key !== "coord"){
                const td = document.createElement("td");
                let text = document.createTextNode(ciudad[key]);
                td.appendChild(text);
                tr.appendChild(td);  
              } else {
                for (const k in ciudad[key]) {
                  const td = document.createElement("td");
                  let text = document.createTextNode(ciudad[key][k]);
                  td.appendChild(text);
                  tr.appendChild(td);
                }
              }
            }
            tbody.appendChild(tr);
          });
          tabla.appendChild(thead);
          tabla.appendChild(tbody);
          contenerdorTabla.appendChild(tabla);
        }
      }
    };
  }

  export function AgregarCiudad() : void{
    let id :number = parseInt((<HTMLInputElement>(document.getElementById("txtId"))).value);
    let nombre :string = (<HTMLInputElement>(document.getElementById("txtNombre"))).value;
    let pais :string = (<HTMLInputElement>(document.getElementById("txtPais"))).value;
    let longitud :number = parseInt((<HTMLInputElement>(document.getElementById("txtLongitud"))).value);
    let latitud :number = parseInt((<HTMLInputElement>(document.getElementById("txtLatitud"))).value);
    let ciudad :any =
    {
      "_id": id,
      "name": nombre,
      "country": pais,
      "coord": {"lon": longitud, "lat": latitud}
    };
    let ciudadStr = JSON.stringify(ciudad);
    
    xhttp.open("POST", "./backend/administrarCiudades.php", true);

    let form: FormData = new FormData();
    form.append("accion", "agregarCiudad");
    form.append("ciudad", ciudadStr);

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
      }
    };
  }
}
