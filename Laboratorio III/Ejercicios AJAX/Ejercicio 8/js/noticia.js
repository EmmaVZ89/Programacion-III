"use strict";
var Noticias;
(function (Noticias) {
    let xhttp = new XMLHttpRequest();
    let noticia = 0;
    let idN = setInterval(verNoticias, 5000);
    let flagInterval = true;
    function verNoticias() {
        getNoticia(noticia);
        noticia++;
    }
    function getNoticia(numNoticia) {
        xhttp.open("POST", "./backend/back.php", true);
        let form = new FormData();
        form.append("noticia", numNoticia.toString());
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                let div = document.getElementById("noticias");
                let respuesta = xhttp.responseText;
                if (respuesta != "") {
                    div.innerHTML = respuesta;
                    div.style.backgroundColor = "rgba(0, 255, 0, 0.2)";
                    div.style.borderRadius = "5px";
                    setTimeout(() => {
                        div.style.backgroundColor = "white";
                    }, 200);
                }
                else {
                    noticia = 0;
                }
            }
        };
    }
    function detenerNoticias() {
        if (flagInterval) {
            clearInterval(idN);
            flagInterval = false;
        }
        else {
            idN = setInterval(verNoticias, 1000);
            flagInterval = true;
        }
    }
    Noticias.detenerNoticias = detenerNoticias;
    function retrocederNoticia() {
        if (flagInterval) {
            clearInterval(idN);
            flagInterval = false;
        }
        if (noticia - 1 >= 0) {
            noticia--;
        }
        getNoticia(noticia);
    }
    Noticias.retrocederNoticia = retrocederNoticia;
    function adelantarNoticia() {
        if (flagInterval) {
            clearInterval(idN);
            flagInterval = false;
        }
        noticia++;
        getNoticia(noticia);
    }
    Noticias.adelantarNoticia = adelantarNoticia;
})(Noticias || (Noticias = {}));
//# sourceMappingURL=noticia.js.map