$(()=>{

    VerificarJWT();

    AdministrarVerificarJWT();

    AdministrarLogout();

    AdministrarListarUsuarios();

    AdministrarListarAutos();

    AdministrarAgregar();

    // ***********************************
    
    $("#alta_auto").on("click", ()=>{

        AltaAuto();
    });

    FiltrarAutosPrecioColor();

    PrecioPromedioAutos();
});


function VerificarJWT() {
    
    //RECUPERO DEL LOCALSTORAGE
    let jwt = localStorage.getItem("jwt");

    $.ajax({
        type: 'GET',
        url: URL_API + "verificar_token",
        dataType: "json",
        data: {},
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true
    })
    .done(function (obj_rta:any) {

        console.log(obj_rta);

        if(obj_rta.exito){

            let app = obj_rta.jwt.api;
            let usuario = obj_rta.jwt.usuario;

            let alerta:string = ArmarAlert(app + "<br>" + JSON.stringify(usuario));

            $("#divResultado").html(alerta).toggle(2000);
            $("#perfil").html(usuario.perfil);
        }
        else{

            let alerta:string = ArmarAlert(obj_rta.mensaje, "danger");

            $("#divResultado").html(alerta).toggle(2000);

            setTimeout(() => {
                $(location).attr('href', "./login.html");
            }, 1500);
        }
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta).show(2000);
    });    
}

function AdministrarVerificarJWT() {
    
    $("#verificarJWT").on("click", ()=>{

        VerificarJWT();
    });
}

function AdministrarLogout() {

    $("#logout").on("click", ()=>{

        localStorage.removeItem("jwt");

        let alerta:string = ArmarAlert('Usuario deslogueado!');
    
        $("#divResultado").html(alerta).show(2000);

        setTimeout(() => {
            $(location).attr('href',"./login.html");
        }, 1500);

    });

}

function AdministrarListarUsuarios() {

    $("#listar_usuarios").on("click", ()=>{
        ObtenerListadoUsuarios();
    });
}

function AdministrarListarAutos() {

    $("#listar_autos").on("click", ()=>{
        ObtenerListadoAutos();
    });
}

function AdministrarAgregar() {

    $("#alta_producto").on("click", ()=>{
        ArmarFormularioAlta();
    });
}

function ArmarFormularioAlta()
{
    $("#divResultado").html("");

    let formulario = MostrarFormAuto("alta");

    $("#divResultado").html(formulario).show(1000);
} 

function Agregar(e:any):void 
{  
    e.preventDefault();

    let jwt = localStorage.getItem("jwt");

    let codigo = $("#codigo").val();
    let marca = $("#marca").val();
    let precio = $("#precio").val();
    let foto: any = (<HTMLInputElement>document.getElementById("foto"));

    let form = new FormData();
    form.append("obj", JSON.stringify({"codigo":codigo, "marca":marca, "precio":precio}));
    form.append("foto", foto.files[0]);

    $.ajax({
        type: 'POST',
        url: URL_API + "productos_bd",
        dataType: "text",
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        let alerta:string = ArmarAlert(resultado);

        $("#divResultado").html(alerta);
        
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta);

    });    
}

// FUNCIONES PARA AUTOS
function ObtenerListadoAutos() {
   
    $("#tabla-autos").html("");

    let jwt = localStorage.getItem("jwt");

    $.ajax({
        type: 'GET',
        url: URL_API + "autos",
        dataType: "json",
        data: {},
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true
    })
    .done(function (resultado:any) {
        // console.log(resultado);

        let tabla:string = ArmarTablaAutos(resultado.dato);

        if(resultado.exito) {
            $("#tabla-autos").html(tabla).show(1000);

            $('[data-action="modificar-auto"]').on('click', function (e) {
                
                let obj_auto_string : any = $(this).attr("data-obj_auto");
                let obj_auto = JSON.parse(obj_auto_string);
    
                let formulario = MostrarFormAuto("modificacion", obj_auto);
            
                $("#cuerpo_modal_prod").html(formulario);           
            });
       
            $('[data-action="eliminar-auto"]').on('click', function (e) {
    
                let obj_auto_string : any = $(this).attr("data-obj_auto");
                let obj_auto = JSON.parse(obj_auto_string);
    
                let formulario = MostrarFormAuto("baja", obj_auto);
            
                $("#cuerpo_modal_prod").html(formulario);
            });    
        } else {
            let alerta:string = ArmarAlert(resultado.mensaje, "danger");

            $("#divResultado").html(alerta).show(2000);    
        }
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta).show(2000);
    });    
}

function ArmarTablaAutos(autos:[]) : string 
{   
    let tabla:string = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>COLOR</th><th>MARCA</th><th>PRECIO</th><th>MODELO</th><th style="width:110px">ACCIONES</th></tr>';

    if(autos.length == 0)
    {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
    }
    else
    {
        autos.forEach((auto : any) => {
            tabla += "<tr>";
            for (const key in auto) {
                if(key != "id") {
                    tabla += "<td>"+auto[key]+"</td>";
                }
            }
            tabla += "<td><a href='#' class='btn' data-action='modificar-auto' data-obj_auto='"+JSON.stringify(auto)+"' title='Modificar'"+
            " data-toggle='modal' data-target='#ventana_modal_prod' ><span class='fas fa-edit'></span></a>";
            tabla += "<a href='#' class='btn' data-action='eliminar-auto' data-obj_auto='"+JSON.stringify(auto)+"' title='Eliminar'"+
            " data-toggle='modal' data-target='#ventana_modal_prod' ><span class='fas fa-times'></span></a>";
            tabla += "</td>";
            tabla += "</tr>";    
        });
    }

    tabla += "</table>";

    return tabla;
}

function MostrarFormAuto(accion:string, obj_auto:any=null) : string 
{
    let funcion = "";
    let encabezado = "";
    let solo_lectura = "";
    let solo_lectura_pk = "";

    switch (accion) {
        case "alta":
            funcion = 'AgregarAuto(event)';
            encabezado = 'AGREGAR AUTO';
            break;

         case "baja":
            funcion = 'EliminarAuto(event)';
            encabezado = 'ELIMINAR AUTO';
            solo_lectura = "readonly";
            solo_lectura_pk = "readonly";
            break;
    
        case "modificacion":
            funcion = 'ModificarAuto(event)';
            encabezado = 'MODIFICAR AUTO';
            solo_lectura_pk = "readonly";
            break;
    }

    let id = "";
    let color = "";
    let marca = "";
    let precio = "";
    let modelo = "";

    if (obj_auto !== null) 
    {
        id = obj_auto.id;
        color = obj_auto.color;
        marca = obj_auto.marca;
        precio = obj_auto.precio;
        modelo = obj_auto.modelo;
    }

    let form:string = '<h3 style="padding-top:1em;">'+encabezado+'</h3>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="codigo">ID:</label>\
                                        <input type="text" class="form-control " id="idAuto" value="'+id+'" '+solo_lectura_pk+' required>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="marca">Color:</label>\
                                        <input type="text" class="form-control" id="color" placeholder="Ingresar color"\
                                            name="color" value="'+color+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Marca:</label>\
                                        <input type="text" class="form-control" id="marca" placeholder="Ingresar marca" name="marca"\
                                            value="'+marca+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Precio:</label>\
                                        <input type="text" class="form-control" id="precio" placeholder="Ingresar precio" name="precio"\
                                            value="'+precio+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Modelo:</label>\
                                        <input type="text" class="form-control" id="modelo" placeholder="Ingresar modelo" name="apellido"\
                                            value="'+modelo+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="row justify-content-between">\
                                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar">\
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="'+funcion+'" >Aceptar</button>\
                                    </div>\
                                </form>\
                            </div>\
                        </div>';

    return form;
}

function ModificarAuto(e:any):void 
{  
    e.preventDefault();

    let jwt = localStorage.getItem("jwt");

    let id = $("#idAuto").val();
    let color = $("#color").val();
    let marca = $("#marca").val();
    let precio = $("#precio").val();
    let modelo = $("#modelo").val();

    let dato: any = {};
    dato.id = id;
    dato.color = color;
    dato.marca = marca;
    dato.precio = precio;
    dato.modelo = modelo;

    // let form: FormData = new FormData();
    // form.append("auto", JSON.stringify(dato));
    
    $.ajax({
        type: "PUT",
        url: URL_API + "autos/modificar",
        dataType: "json",
        data: dato,
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);
 
        ObtenerListadoAutos();

        $("#cuerpo_modal_prod").html("");
        
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta).toggle(2000);

    });    
}

function EliminarAuto(e:any):void 
{
    e.preventDefault();

    let color = $("#color").val();
    let marca = $("#marca").val();

    let confirmacion = confirm(`¿Desea eliminar el auto "${marca} ${color}"?`);
    if(confirmacion) {
        let jwt = localStorage.getItem("jwt");

        let id = $("#idAuto").val();
    
        $.ajax({
            type: 'DELETE',
            url: URL_API + "autos/eliminar",
            dataType: "text",
            data: {"id":id},
            headers : {'Authorization': 'Bearer ' + jwt},
            async: true
        })
        .done(function (resultado:any) {
    
            console.log(resultado);
    
            ObtenerListadoAutos();
            
            $("#cuerpo_modal_prod").html("");
        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
    
            let retorno = JSON.parse(jqXHR.responseText);
    
            let alerta:string = ArmarAlert(retorno.mensaje, "danger");
    
            $("#divResultado").html(alerta).toggle(2000);
        });        
    }
}


// FUNCIONES PARA USUARIOS
function ObtenerListadoUsuarios() {
   
    $("#tabla-usuarios").html("");

    let jwt = localStorage.getItem("jwt");

    $.ajax({
        type: 'GET',
        url: URL_API + "usuarios",
        dataType: "json",
        data: {},
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true
    })
    .done(function (resultado:any) {
        // console.log(resultado);

        let tabla:string = ArmarTablaUsuarios(resultado.dato);

        if(resultado.exito) {
            $("#tabla-usuarios").html(tabla).show(1000);

            $('[data-action="modificar-usuario"]').on('click', function (e) {
                
                let obj_user_string : any = $(this).attr("data-obj_user");
                let obj_user = JSON.parse(obj_user_string);
    
                let formulario = MostrarFormUsuario("modificacion", obj_user);
            
                $("#cuerpo_modal_prod").html(formulario);           
            });
       
            $('[data-action="eliminar-usuario"]').on('click', function (e) {
    
                let obj_user_string : any = $(this).attr("data-obj_user");
                let obj_user = JSON.parse(obj_user_string);
    
                let formulario = MostrarFormUsuario("baja", obj_user);
            
                $("#cuerpo_modal_prod").html(formulario);
            });    
        } else {
            let alerta:string = ArmarAlert(resultado.mensaje, "danger");

            $("#divResultado").html(alerta).show(2000);    
        }
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta).show(2000);
    });    
}

function ArmarTablaUsuarios(usuarios:[]) : string 
{   
    let tabla:string = '<table class="table table-success table-striped table-hover">';
    tabla += '<tr><th>CORREO</th><th>NOMBRE</th><th>APELLIDO</th><th>PERFIL</th><th>FOTO</th><th style="width:110px">ACCIONES</th></tr>';

    if(usuarios.length == 0)
    {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
    }
    else
    {
        usuarios.forEach((user : any) => {
            tabla += "<tr>";
            for (const key in user) {
                if(key != "foto" && key != "clave" && key != "id") {
                    tabla += "<td>"+user[key]+"</td>";
                } else if(key == "foto"){
                    tabla += "<td><img src='"+URL_API+user.foto+"' width='50px' height='50px'></td>";
                }
            }
            tabla += "<td><a href='#' class='btn' data-action='modificar-usuario' data-obj_user='"+JSON.stringify(user)+"' title='Modificar'"+
            " data-toggle='modal' data-target='#ventana_modal_prod' ><span class='fas fa-edit'></span></a>";
            tabla += "<a href='#' class='btn' data-action='eliminar-usuario' data-obj_user='"+JSON.stringify(user)+"' title='Eliminar'"+
            " data-toggle='modal' data-target='#ventana_modal_prod' ><span class='fas fa-times'></span></a>";
            tabla += "</td>";
            tabla += "</tr>";    
        });
    }

    tabla += "</table>";

    return tabla;
}

function MostrarFormUsuario(accion:string, obj_user:any=null) : string 
{
    let funcion = "";
    let encabezado = "";
    let solo_lectura = "";
    let solo_lectura_pk = "";

    switch (accion) {
         case "baja":
            funcion = 'EliminarUsuario(event)';
            encabezado = 'ELIMINAR USUARIO';
            solo_lectura = "readonly";
            solo_lectura_pk = "readonly";
            break;
    
        case "modificacion":
            funcion = 'ModificarUsuario(event)';
            encabezado = 'MODIFICAR USUARIO';
            solo_lectura_pk = "readonly";
            break;
    }

    let id = "";
    let correo = "";
    let clave = "";
    let nombre = "";
    let apellido = "";
    let perfil = "";
    let foto = "./img/usr_default.jpg";

    if (obj_user !== null) 
    {
        id = obj_user.id;
        correo = obj_user.correo;
        clave = obj_user.clave;
        nombre = obj_user.nombre;
        apellido = obj_user.apellido;
        perfil = obj_user.perfil;
        foto = URL_API + obj_user.foto;       
    }

    let form:string = '<h3 style="padding-top:1em;">'+encabezado+'</h3>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="codigo">ID:</label>\
                                        <input type="text" class="form-control " id="id" value="'+id+'" '+solo_lectura_pk+' required>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="marca">Correo:</label>\
                                        <input type="text" class="form-control" id="correo" placeholder="Ingresar correo"\
                                            name="correo" value="'+correo+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Clave:</label>\
                                        <input type="text" class="form-control" id="clave" placeholder="Ingresar clave" name="clave"\
                                            value="'+clave+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Nombre:</label>\
                                        <input type="text" class="form-control" id="nombre" placeholder="Ingresar Nombre" name="nombre"\
                                            value="'+nombre+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="precio">Apellido:</label>\
                                        <input type="text" class="form-control" id="apellido" placeholder="Ingresar apellido" name="apellido"\
                                            value="'+apellido+'" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                    <label for="perfil">Perfil:</label>\
                                    <select id="dpPerfil" class="form-select">\
                                    <option>propietario</option>\
                                    <option>supervisor</option>\
                                    <option>empleado</option>\
                                  </select>\
                                      <div class="valid-feedback">OK.</div>\
                                  <div class="invalid-feedback">Valor requerido.</div>\
                                  </div>\
                                  <div class="form-group">\
                                        <label for="foto">Foto:</label>\
                                        <input type="file" class="form-control" id="foto" name="foto" '+solo_lectura+' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="row justify-content-between"><img id="img_user" src="'+foto+'" width="200px"></div><br>\
                                    <div class="row justify-content-between">\
                                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar">\
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="'+funcion+'" >Aceptar</button>\
                                    </div>\
                                </form>\
                            </div>\
                        </div>';

    return form;
}

function ModificarUsuario(e:any):void 
{  
    e.preventDefault();

    let jwt = localStorage.getItem("jwt");

    let id = $("#id").val();
    let correo = $("#correo").val();
    let clave = $("#clave").val();
    let nombre = $("#nombre").val();
    let apellido = $("#apellido").val();
    let perfil = $("#dpPerfil").val();
    let foto = $("#foto").prop("files")[0];

    let dato: any = {};
    dato.id = id;
    dato.correo = correo;
    dato.clave = clave;
    dato.nombre = nombre;
    dato.apellido = apellido;
    dato.perfil = perfil;

    let form: FormData = new FormData();

    form.append("usuario", JSON.stringify(dato));
    form.append("foto", foto);

    $.ajax({
        type: 'POST',
        url: URL_API + "usuarios/modificar",
        dataType: "text",
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true
    })
    .done(function (resultado:any) {

        console.log(resultado);

        ObtenerListadoUsuarios();

        $("#cuerpo_modal_prod").html("");
        
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {

        let retorno = JSON.parse(jqXHR.responseText);

        let alerta:string = ArmarAlert(retorno.mensaje, "danger");

        $("#divResultado").html(alerta).toggle(2000);

    });    
}

function EliminarUsuario(e:any):void 
{
    e.preventDefault();

    let nombre = $("#nombre").val();
    let apellido = $("#apellido").val();

    let confirmacion = confirm(`¿Desea eliminar el usuario "${nombre} ${apellido}"?`);
    if(confirmacion) {
        let jwt = localStorage.getItem("jwt");

        let id = $("#id").val();
    
        $.ajax({
            type: 'POST',
            url: URL_API + "usuarios/eliminar",
            dataType: "text",
            data: {"id":id},
            headers : {'Authorization': 'Bearer ' + jwt},
            async: true
        })
        .done(function (resultado:any) {
    
            console.log(resultado);
    
            if(resultado.exito) {
                ObtenerListadoUsuarios();
            } 
            
            $("#cuerpo_modal_prod").html("");
        })
        .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
    
            let retorno = JSON.parse(jqXHR.responseText);
    
            let alerta:string = ArmarAlert(retorno.mensaje, "danger");
    
            $("#divResultado").html(alerta).toggle(2000);
        });        
    }
}


//*********************************/
//******************************** */
function AltaAuto(): void {
    // VerificarJWT();
  
    let form: string = `
          <div class="container bg-darkcyan">
          <div class="row justify-content-center">
              <div class=" mt-2 p-4 rounded-3 " style="background-color: darkcyan;">
                  <form action="">
                      <div class="mb-3">
                          <div class="d-flex">
                              <input type="text" class="form-control" placeholder="Marca" id="txtMarca">
                          </div>
                      </div>
                      <div class="mb-3">
                          <div class="d-flex">
                              <input type="text" placeholder="Color" class="form-control" id="txtColor">
                          </div>
                      </div>
                      <div class="mb-3">
                          <div class="d-flex">
                              <input type="text" placeholder="Modelo" class="form-control" id="txtModelo">
                          </div>
                      </div>
                      <div class="mb-3">
                          <div class="d-flex">
                              <input type="text" placeholder="Precio" class="form-control" id="txtPrecio">
                          </div>
                      </div>
                      <div class="row content-center">
                                  <br>
                                  <br>
                              <div id="divResultadoAgregarAuto" class="col-12 col-md-12 container-fluid">
                              </div>
                      </div>
                      <div class="row justify-content-around">
                          <button type="submit" id="btnAgregar" class="col-5 btn btn-primary">Agregar</button>
                          <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>`;
  
    $("#tabla-autos").html(form);
  
    $("#btnAgregar").on("click", function (e) {
        e.preventDefault();
        let jwt = localStorage.getItem("jwt");

      let auto: any = {};
      let marca = $("#txtMarca").val();
      let color = $("#txtColor").val();
      let modelo = $("#txtModelo").val();
      let precio = $("#txtPrecio").val();
      auto.marca = marca;
      auto.color = color;
      auto.modelo = modelo;
      auto.precio = precio;
  
      $.ajax({
        type: "POST",
        url: URL_API + "autos",
        dataType: "json",
        data: { auto: JSON.stringify(auto) },
        headers : {'Authorization': 'Bearer ' + jwt},
        async: true,
      })
        .done(function (resultado: any) {
          let mensaje: string = "Usuario válido!";
          let tipo: string = "success";
          console.log(resultado.mensaje);
          if (resultado.exito) {
            // e.preventDefault();
            mensaje = resultado.mensaje;
            let alerta: string = ArmarAlert(mensaje, tipo);
            $("#divResultado").html(alerta).toggle(2000);
          } else {
            mensaje = resultado.mensaje;
            tipo = "danger";
            let alerta: string = ArmarAlert(mensaje, tipo);
            $("#divResultado").html(alerta).toggle(2000);
          }
        })
        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
          console.log("error al agregar.");
        });
    });

}
  
function FiltrarAutosPrecioColor() {
    // VerificarJWT();

    let jwt = localStorage.getItem("jwt");
  
    $.ajax({
      type: "GET",
      url: URL_API + "autos",
      dataType: "json",
      data: {},
      headers : {'Authorization': 'Bearer ' + jwt},
      async: true,
    })
      .done(function (resultado: any) {
        // let usuario: any;
        // usuario = JSON.parse(resultado.payload.dat);
        let filtrado = resultado.dato.filter((dato: any) => dato.precio > 199999 && dato.color != "rojo");
        console.log(filtrado);
      })
      .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        let retorno = JSON.parse(jqXHR.responseText);
        let alerta:string = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta).toggle(2000);
    });        

  }

function PrecioPromedioAutos() {
    // VerificarJWT();

    let jwt = localStorage.getItem("jwt");
  
    $.ajax({
      type: "GET",
      url: URL_API + "autos",
      dataType: "json",
      data: {},
      headers : {'Authorization': 'Bearer ' + jwt},
      async: true,
    })
      .done(function (resultado: any) {
        let mapeado = resultado.dato.filter(function (auto: any) {
            if (auto.marca[0] == "F" || auto.marca[0] == "f") {
              return { precio: auto.precio };
            }
          });

          let prom = mapeado.reduce((a: any, x: any) => parseInt(a) + parseInt(x.precio), 0) / mapeado.length;
          let mensaje = "El precio promedio de autos es: " + prom;
          console.log(mensaje);
      })
      .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        let retorno = JSON.parse(jqXHR.responseText);
        let alerta:string = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta).toggle(2000);
    });        

  }
  