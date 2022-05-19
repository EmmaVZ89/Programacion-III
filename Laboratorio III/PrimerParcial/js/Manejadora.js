"use strict";
/// <reference path="./Producto.ts" />
/// <reference path="./ProductoEnvasado.ts" />
///  <reference path="./Iparte2.ts" />
///  <reference path="./Iparte3.ts" />
///  <reference path="./Iparte4.ts" />
let xhttp = new XMLHttpRequest();
var PrimerParcial;
(function (PrimerParcial) {
    class Manejadora {
        // FUNCIONES PRODUCTO
        static AgregarProductoJSON() {
            let nombre = document.getElementById("nombre").value;
            let origen = document.getElementById("cboOrigen").value;
            xhttp.open("POST", "./backend/AltaProductoJSON.php", true);
            let form = new FormData();
            form.append("nombre", nombre);
            form.append("origen", origen);
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);
                }
            };
        }
        static MostrarProductosJSON() {
            xhttp.open("GET", "./BACKEND/ListadoProductosJSON.php", true);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = xhttp.responseText;
                    let productosJson = JSON.parse(respuesta);
                    console.log(productosJson);
                    const contenerdorTabla = document.getElementById("divTabla");
                    contenerdorTabla.innerHTML = "";
                    // ARMADO DE TABLA
                    const tabla = document.createElement("table");
                    // Armado de thead
                    const thead = document.createElement("thead");
                    for (const key in productosJson[0]) {
                        const th = document.createElement("th");
                        let text = document.createTextNode(key.toUpperCase());
                        th.appendChild(text);
                        thead.appendChild(th);
                    }
                    // Armado de tbody
                    const tbody = document.createElement("tbody");
                    productosJson.forEach((producto) => {
                        const tr = document.createElement("tr");
                        for (const key in producto) {
                            const td = document.createElement("td");
                            let text = document.createTextNode(producto[key]);
                            td.appendChild(text);
                            tr.appendChild(td);
                        }
                        tbody.appendChild(tr);
                    });
                    tabla.appendChild(thead);
                    tabla.appendChild(tbody);
                    contenerdorTabla.appendChild(tabla); // se inyecta toda la tabla en el contenedor
                }
            };
            xhttp.send();
        }
        static VerificarProductoJSON() {
            let nombre = document.getElementById("nombre").value;
            let origen = document.getElementById("cboOrigen").value;
            xhttp.open("POST", "./BACKEND/VerificarProductoJSON.php", true);
            let form = new FormData();
            form.append("nombre", nombre);
            form.append("origen", origen);
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);
                }
            };
        }
        static MostrarInfoCookie() {
            let nombre = document.getElementById("nombre").value;
            let origen = document.getElementById("cboOrigen").value;
            xhttp.open("GET", "./BACKEND/MostrarCookie.php?nombre=" + nombre + "&origen=" + origen, true);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    const contenerdorInfo = document.getElementById("divInfo");
                    contenerdorInfo.innerText = respuesta.mensaje;
                    console.log(respuesta.mensaje);
                }
            };
            xhttp.send();
        }
        // FUNCIONES PRODUCTO ENVASADO
        static AgregarProductoSinFoto() {
            let codigoBarra = document.getElementById("codigoBarra").value;
            let nombre = document.getElementById("nombre").value;
            let origen = document.getElementById("cboOrigen").value;
            let precio = parseInt(document.getElementById("precio").value);
            let producto = new Entidades.ProductoEnvasado(nombre, origen, 0, codigoBarra, precio);
            xhttp.open("POST", "./backend/AgregarProductoSinFoto.php", true);
            let form = new FormData();
            form.append("producto_json", producto.ToJSON());
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);
                }
            };
        }
        static MostrarProductosEnvasados(tipoTabla) {
            xhttp.open("GET", "./BACKEND/ListadoProductosEnvasados.php?tabla=json", true);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = xhttp.responseText;
                    let productosJson = JSON.parse(respuesta);
                    console.log(productosJson);
                    const contenerdorTabla = document.getElementById("divTabla");
                    contenerdorTabla.innerHTML = "";
                    let tablaStr = `
          <table>
              <thead>`;
                    for (const key in productosJson[0]) {
                        tablaStr += `<th>${key.toLocaleUpperCase()}</th>`;
                    }
                    tablaStr += `<th>ACCIONES</th>`;
                    tablaStr += `</thead>`;
                    tablaStr += `<tbody>`;
                    productosJson.forEach((producto) => {
                        tablaStr += `<tr>`;
                        for (const key in producto) {
                            if (key != "pathFoto") {
                                tablaStr += `<td>${producto[key]}</td>`;
                            }
                            else {
                                tablaStr += `<td><img src='./BACKEND${producto[key]}' width='50px' alt='img'></td>`;
                            }
                        }
                        let productoStr = JSON.stringify(producto);
                        if (tipoTabla == 1) {
                            tablaStr += `<td> <input type="button" value="Modificar" class="btn btn-info" onclick=PrimerParcial.Manejadora.BtnModificarProducto(${productoStr})></td>`;
                            tablaStr += `<td> <input type="button" value="Eliminar" class="btn btn-danger" onclick=PrimerParcial.Manejadora.EliminarProducto(${productoStr})></td>`;
                        }
                        else if (tipoTabla == 2) {
                            tablaStr += `<td> <input type="button" value="Modificar" class="btn btn-info" onclick=PrimerParcial.Manejadora.BtnModificarProductoFoto(${productoStr})></td>`;
                            tablaStr += `<td> <input type="button" value="Eliminar" class="btn btn-danger" onclick=PrimerParcial.Manejadora.BorrarProductoFoto(${productoStr})></td>`;
                        }
                        tablaStr += `</tr>`;
                    });
                    tablaStr += `</tbody>`;
                    tablaStr += `</table>`;
                    contenerdorTabla.innerHTML = tablaStr;
                }
            };
            xhttp.send();
        }
        // IMPLEMENTACION INTERFACE IPARTE2
        static EliminarProducto(obj) {
            let confirmacion = confirm(`Desea eliminar el producto con nombre "${obj.nombre}" y origen
        "${obj.origen}" ?`);
            if (confirmacion) {
                xhttp.open("POST", "./BACKEND/EliminarProductoEnvasado.php", true);
                let form = new FormData();
                form.append("producto_json", JSON.stringify(obj));
                xhttp.send(form);
                xhttp.onreadystatechange = () => {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        let respuesta = JSON.parse(xhttp.responseText);
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);
                        Manejadora.MostrarProductosEnvasados(1);
                    }
                };
            }
        }
        static ModificarProducto() {
            const inpId = document.getElementById("idProducto");
            const inpCodigoBarra = document.getElementById("codigoBarra");
            const inpNombre = document.getElementById("nombre");
            const inpCboOrigen = document.getElementById("cboOrigen");
            const inpPrecio = document.getElementById("precio");
            let id = parseInt(inpId.value);
            let codigoBarra = inpCodigoBarra.value;
            let nombre = inpNombre.value;
            let origen = inpCboOrigen.value;
            let precio = parseInt(inpPrecio.value);
            const producto = {
                id: id,
                codigoBarra: codigoBarra,
                nombre: nombre,
                origen: origen,
                precio: precio,
            };
            xhttp.open("POST", "./BACKEND/ModificarProductoEnvasado.php", true);
            let form = new FormData();
            form.append("producto_json", JSON.stringify(producto));
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    if (respuesta.exito) {
                        Manejadora.MostrarProductosEnvasados(1);
                    }
                    else {
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);
                    }
                    inpId.disabled = false;
                    inpId.value = "";
                    inpCodigoBarra.value = "";
                    inpNombre.value = "";
                    inpCboOrigen.value = "";
                    inpPrecio.value = "";
                }
            };
        }
        static BtnModificarProducto(obj) {
            document.getElementById("idProducto").value = obj.id;
            document.getElementById("codigoBarra").value = obj.codigoBarra;
            document.getElementById("nombre").value = obj.nombre;
            document.getElementById("cboOrigen").value = obj.origen;
            document.getElementById("precio").value = obj.precio;
            document.getElementById("idProducto").disabled = true;
        }
        // IMPLEMETACION INTERFACE IPARTE3
        static VerificarProductoEnvasado() {
            const inpNombre = document.getElementById("nombre");
            const inpCboOrigen = document.getElementById("cboOrigen");
            let nombre = inpNombre.value;
            let origen = inpCboOrigen.value;
            let producto = { nombre: nombre, origen: origen };
            xhttp.open("POST", "./BACKEND/VerificarProductoEnvasado.php", true);
            let form = new FormData();
            form.append("obj_producto", JSON.stringify(producto));
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    if (respuesta.id == undefined) {
                        console.log("Producto no encontrado");
                    }
                    else {
                        const contenerdorInfo = document.getElementById("divInfo");
                        contenerdorInfo.innerText = xhttp.responseText;
                        console.log("Producto encontrado");
                        console.log(respuesta);
                    }
                }
            };
        }
        static AgregarProductoFoto() {
            const inpCodigoBarra = document.getElementById("codigoBarra");
            const inpNombre = document.getElementById("nombre");
            const inpCboOrigen = document.getElementById("cboOrigen");
            const inpPrecio = document.getElementById("precio");
            const foto = document.getElementById("foto");
            let codigoBarra = inpCodigoBarra.value;
            let nombre = inpNombre.value;
            let origen = inpCboOrigen.value;
            let precio = inpPrecio.value;
            xhttp.open("POST", "./BACKEND/AgregarProductoEnvasado.php", true);
            let form = new FormData();
            form.append("codigoBarra", codigoBarra);
            form.append("nombre", nombre);
            form.append("origen", origen);
            form.append("precio", precio);
            form.append("foto", foto.files[0]);
            xhttp.setRequestHeader("enctype", "multipart/form-data");
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    console.log(respuesta.mensaje);
                    alert(respuesta.mensaje);
                    Manejadora.MostrarProductosEnvasados(2);
                }
            };
        }
        static BorrarProductoFoto(obj) {
            let confirmacion = confirm(`Desea eliminar el producto con nombre "${obj.nombre}" y codigo de barra
      "${obj.codigoBarra}" ?`);
            if (confirmacion) {
                xhttp.open("POST", "./BACKEND/BorrarProductoEnvasado.php", true);
                let form = new FormData();
                form.append("producto_json", JSON.stringify(obj));
                xhttp.send(form);
                xhttp.onreadystatechange = () => {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        let respuesta = JSON.parse(xhttp.responseText);
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);
                        Manejadora.MostrarProductosEnvasados(2);
                    }
                };
            }
        }
        static ModificarProductoFoto() {
            const inpId = document.getElementById("idProducto");
            const inpCodigoBarra = document.getElementById("codigoBarra");
            const inpNombre = document.getElementById("nombre");
            const inpCboOrigen = document.getElementById("cboOrigen");
            const inpPrecio = document.getElementById("precio");
            let foto = document.getElementById("foto");
            let id = parseInt(inpId.value);
            let codigoBarra = inpCodigoBarra.value;
            let nombre = inpNombre.value;
            let origen = inpCboOrigen.value;
            let precio = parseInt(inpPrecio.value);
            const producto = {
                id: id,
                codigoBarra: codigoBarra,
                nombre: nombre,
                origen: origen,
                precio: precio,
            };
            xhttp.open("POST", "./BACKEND/ModificarProductoEnvasadoFoto.php", true);
            let form = new FormData();
            form.append("producto_json", JSON.stringify(producto));
            form.append("foto", foto.files[0]);
            xhttp.setRequestHeader("enctype", "multipart/form-data");
            xhttp.send(form);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = JSON.parse(xhttp.responseText);
                    if (respuesta.exito) {
                        Manejadora.MostrarProductosEnvasados(2);
                    }
                    else {
                        console.log(respuesta.mensaje);
                        alert(respuesta.mensaje);
                    }
                    inpId.disabled = false;
                    inpId.value = "";
                    inpCodigoBarra.value = "";
                    inpNombre.value = "";
                    inpCboOrigen.value = "";
                    inpPrecio.value = "";
                }
            };
        }
        static BtnModificarProductoFoto(obj) {
            document.getElementById("idProducto").value = obj.id;
            document.getElementById("codigoBarra").value = obj.codigoBarra;
            document.getElementById("nombre").value = obj.nombre;
            document.getElementById("cboOrigen").value = obj.origen;
            document.getElementById("precio").value = obj.precio;
            document.getElementById("idProducto").disabled = true;
            const img = document.getElementById("imgFoto");
            img.src = "./BACKEND" + obj.pathFoto;
        }
        // IMPLEMENTACION INTERFACE IPARTE4
        static MostrarBorradosJSON() {
            xhttp.open("GET", "./BACKEND/MostrarBorradosJSON.php", true);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = xhttp.responseText;
                    let productosJson = JSON.parse(respuesta);
                    const contenerdorInfo = document.getElementById("divInfo");
                    contenerdorInfo.innerHTML = "<h4>BORRADOS</h4>" + respuesta;
                    console.log(productosJson);
                }
            };
            xhttp.send();
        }
        static MostrarFotosModificados() {
            xhttp.open("GET", "./BACKEND/MostrarFotosDeModificados.php", true);
            xhttp.onreadystatechange = () => {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    let respuesta = xhttp.responseText;
                    const contenerdorInfo = document.getElementById("divTabla");
                    contenerdorInfo.innerHTML = "<h4>MODIFICADAS</h4>" + respuesta;
                }
            };
            xhttp.send();
        }
        //###################################################
        //###################################################
        //###################################################
        // Implementacion de interfaces dado que necesito funciones estaticas para realizar las tareas en el
        // documento HTML, y en las interfaces no se puede tener metodos estaticos o desconosco como hacerlo.
        // IMPLEMENTACION DE INTERFACE IPARTE2
        EliminarProducto(obj) { }
        ModificarProducto(obj) { }
        // IMPLEMENTACION DE INTERFACE IPARTE3
        VerificarProductoEnvasado() { }
        AgregarProductoFoto() { }
        BorrarProductoFoto(obj) { }
        ModificarProductoFoto(obj) { }
        // IMPLEMENTACION DE INTERFACE IPARTE4
        MostrarBorradosJSON() { }
        MostrarFotosModificados() { }
    }
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
//# sourceMappingURL=Manejadora.js.map