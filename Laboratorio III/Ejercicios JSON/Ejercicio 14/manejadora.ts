namespace Entidades {
  let xhttp: XMLHttpRequest = new XMLHttpRequest();

  export function CargarRemeras(): void {
    let pagina = "./backend/administrarRemeras.php";

    xhttp.open("POST", pagina, true);
    // xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");

    let form: FormData = new FormData();
    form.append("accion", "traerRemeras");

    xhttp.send(form);

    xhttp.onreadystatechange = () => {
      var DONE = 4;
      var OK = 200;
      if (xhttp.readyState === DONE) {
        if (xhttp.status === OK) {
          let respuesta: string = xhttp.responseText;
          let remerasJson = JSON.parse(respuesta);

          // {
          //   "id":1,
          //   "slogan":"extend back-end functionalities",
          //   "size":"S",
          //   "price":"£124.03",
          //   "color":"Orange",
          //   "manofacturer":
          //   {
          //     "name":"Quimm",
          //     "logo":"https://robohash.org/nullarepellendusqui.jpg?size=50x50&set=set1",
          //     "location":
          //     {
          //       "country":"China",
          //       "city":"Guangdu"
          //     }
          //   }
          // }
          const contenedorTabla = <HTMLDivElement>(
            document.getElementById("contenedorTabla")
          );
          const tabla = document.createElement("table");

          // Creacion del Thead
          const thead = document.createElement("thead");
          for (const key in remerasJson[0]) {
            if (key !== "manofacturer") {
              const th = document.createElement("th");
              const texto = document.createTextNode(key.toUpperCase());
              th.appendChild(texto);
              thead.appendChild(th);
            } else {
              for (const k in remerasJson[0]["manofacturer"]) {
                if (k !== "location") {
                  const th = document.createElement("th");
                  const texto = document.createTextNode(k.toUpperCase());
                  th.appendChild(texto);
                  thead.appendChild(th);
                } else {
                  for (const kk in remerasJson[0]["manofacturer"]["location"]) {
                    const th = document.createElement("th");
                    const texto = document.createTextNode(kk.toUpperCase());
                    th.appendChild(texto);
                    thead.appendChild(th);  
                  }
                }
              }
            }
          }

          // Creacion del Tbody
          const tbody = document.createElement("tbody");
          remerasJson.forEach((remera: any) => {
            const tr = document.createElement("tr");
            for (const key in remera) {
              const td = document.createElement("td");
              if(key !== "manofacturer") {
                const texto = document.createTextNode(remera[key]);
                td.appendChild(texto);
                tr.appendChild(td);
              } else {
                for (const key in remera["manofacturer"]) {
                  if(key === "logo") {
                    const td = document.createElement("td");
                    const img = document.createElement("img");
                    const src = remera["manofacturer"]["logo"];
                    img.setAttribute("src", src);
                    img.setAttribute("alt", "img");
                    img.setAttribute("width", "50px");
                    td.appendChild(img);
                    tr.appendChild(td);
                  } else if(key === "location") {
                    for (const key in remera["manofacturer"]["location"]) {
                      const td = document.createElement("td");
                      const texto = document.createTextNode(remera["manofacturer"]["location"][key]);
                      td.appendChild(texto);
                      tr.appendChild(td);      
                    }
                  } else {
                    const td = document.createElement("td");
                    const texto = document.createTextNode(remera["manofacturer"][key]);
                    td.appendChild(texto);
                    tr.appendChild(td);  
                  }
                }
              }
            }
            tbody.appendChild(tr);
          });
          tabla.appendChild(thead);
          tabla.appendChild(tbody);
          contenedorTabla.appendChild(tabla);
        }
      }
    };
  }
}
