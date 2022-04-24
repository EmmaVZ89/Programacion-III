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
/// <reference path="./ajax.ts" />
var Test;
(function (Test) {
    function EnviarJSON() {
        //CREO UN OBJETO JSON
        var persona = { "nombre": "Juan", "edad": 35 };
        var pagina = "../BACKEND/json_test_enviar.php";
        var ajax = new Ajax();
        var params = "miPersona=" + JSON.stringify(persona);
        ajax.Post(pagina, function (resultado) {
            document.getElementById("divResultado").innerHTML = resultado;
            console.clear();
            console.log(resultado);
        }, params, Fail);
    }
    Test.EnviarJSON = EnviarJSON;
    function RecibirJSON() {
        var pagina = "../BACKEND/json_test_recibir.php";
        var ajax = new Ajax();
        ajax.Post(pagina, function (resultado) {
            document.getElementById("divResultado").innerHTML = "";
            console.clear();
            console.log(resultado);
            var objJson = JSON.parse(resultado);
            console.log(objJson.nombre);
        }, "", Fail);
    }
    Test.RecibirJSON = RecibirJSON;
    function Fail(retorno) {
        console.clear();
        console.log("ERROR!!!");
        console.log(retorno);
    }
})(Test || (Test = {}));
