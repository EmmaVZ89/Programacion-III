/// <reference path="../node_modules/@types/jquery/index.d.ts" />

$(() => {
  $("#btnEnviarRegistro").on("click", (e: any) => {
    e.preventDefault();

    let correo = $("#txtCorreo").val();
    let clave = $("#txtClave").val();
    let nombre = $("#txtNombre").val();
    let apellido = $("#txtApellido").val();
    let perfil = $("#dpPerfil").val();
    let foto = $("#foto").prop("files")[0];

    let dato: any = {};
    dato.correo = correo;
    dato.clave = clave;
    dato.nombre = nombre;
    dato.apellido = apellido;
    dato.perfil = perfil;

    let form: FormData = new FormData();

    form.append("usuario", JSON.stringify(dato));
    form.append("foto", foto);

    $.ajax({
      type: "POST",
      url: URL_API + "usuarios",
      dataType: "json",
      data: form,
      async: true,
      contentType: false,
      processData: false,
    })
      .done(function (obj_ret: any) {
        let alerta: string = "";

        if (obj_ret.exito) {
          alerta = ArmarAlert(obj_ret.mensaje + " redirigiendo al login.html...");

          setTimeout(() => {
            $(location).attr("href", "./login.html");
          }, 2000);

        } else {
          alerta = ArmarAlert(obj_ret.mensaje, "danger");
        }

        $("#divResultado").html(alerta);
      })
      .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
        let retorno = JSON.parse(jqXHR.responseText);
        let alerta: string = ArmarAlert(retorno.mensaje, "danger");
        $("#div_mensaje").html(alerta);
      });
  });
});
