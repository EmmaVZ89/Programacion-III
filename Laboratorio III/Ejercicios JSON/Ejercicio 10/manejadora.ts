namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function LeerArchivoJsonCiudades(): void {
    let pagina = "./backend/administrarCiudades.php";

    xhttp.open("POST", pagina, true);
    // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let form : FormData = new FormData();
    form.append("traerCiudades", "traerCiudades");

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
}
