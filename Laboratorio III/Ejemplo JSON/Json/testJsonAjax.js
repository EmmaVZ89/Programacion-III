var Ajax = (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            if (error === void 0) { error = null; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this.xhr.open('GET', ruta);
            _this.xhr.send();
            _this.xhr.onreadystatechange = function () {
                if (_this.xhr.readyState === Ajax.DONE) {
                    if (_this.xhr.status === Ajax.OK) {
                        success(_this.xhr.responseText);
                    }
                    else {
                        if (error !== null) {
                            error(_this.xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            if (error === void 0) { error = null; }
            var parametros = params.length > 0 ? params : "";
            _this.xhr.open('POST', ruta, true);
            _this.xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            _this.xhr.send(parametros);
            _this.xhr.onreadystatechange = function () {
                if (_this.xhr.readyState === Ajax.DONE) {
                    if (_this.xhr.status === Ajax.OK) {
                        success(_this.xhr.responseText);
                    }
                    else {
                        if (error !== null) {
                            error(_this.xhr.status);
                        }
                    }
                }
            };
        };
        this.xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
/// <reference path="../ajax.ts" />
function ObtenerEquiposPorIdPais(idPais) {
    if (idPais == 0) {
        return;
    }
    var pagina = "../BACKEND/paises_equipos.php";
    var params = "idPais=" + idPais.toString();
    var ajax = new Ajax();
    document.getElementById("cboEquipo").innerHTML = "";
    ajax.Post(pagina, function (resultado) {
        var equiposArray = JSON.parse(resultado);
        for (var i = 0; i < equiposArray.length; i++) {
            var elemento = {};
            elemento.value = equiposArray[i].id;
            elemento.innerHTML = equiposArray[i].nombre;
            var opcion = "<option value='" + elemento.value + "'>" + elemento.innerHTML + "</option>";
            document.getElementById("cboEquipo").innerHTML += opcion;
        }
    }, params, Fail);
}
function Fail(retorno) {
    console.clear();
    console.log("ERROR!!!");
    console.log(retorno);
}
