"use strict";
const URL_API = "http://localhost:9876/";
const URL_BASE = "http://localhost/Programacion-III/Laboratorio III/PracticaSP1/";
function ArmarAlert(mensaje, tipo = "success") {
    let alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';
    return alerta;
}
//# sourceMappingURL=funciones.js.map