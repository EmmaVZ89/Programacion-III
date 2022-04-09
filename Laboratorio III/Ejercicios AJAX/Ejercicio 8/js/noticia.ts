namespace Noticias {

    let xhttp : XMLHttpRequest = new XMLHttpRequest();

    let noticia = 0;
    let idN = setInterval(verNoticias, 5000);
    let flagInterval = true;

    function verNoticias(){
        getNoticia(noticia);
        noticia++;
    }

    function getNoticia(numNoticia:number){
        xhttp.open("POST", "./backend/back.php", true);
        let form : FormData = new FormData();
        form.append("noticia", numNoticia.toString());
        xhttp.send(form);
        xhttp.onreadystatechange = () => {
            if(xhttp.readyState == 4 && xhttp.status == 200){
                let div : HTMLDivElement = <HTMLDivElement>document.getElementById("noticias");
                let respuesta : string = xhttp.responseText;

                if(respuesta != ""){
                    div.innerHTML = respuesta;
                    div.style.backgroundColor = "rgba(0, 255, 0, 0.2)";
                    div.style.borderRadius = "5px";

                    setTimeout(() => {
                        div.style.backgroundColor = "white";
                    }, 200);
                    
                } else {
                    noticia = 0;
                }
            }
        }
    }

    export function detenerNoticias() {
        if(flagInterval){
            clearInterval(idN);
            flagInterval = false;
        } else {
            idN = setInterval(verNoticias, 1000);
            flagInterval = true;  
        }
    }

    export function retrocederNoticia() {
        if(flagInterval){
            clearInterval(idN);
            flagInterval = false;
        }
        if(noticia - 1 >= 0) {
            noticia--;
        }
        getNoticia(noticia);        
    }

    export function adelantarNoticia() {
        if(flagInterval){
            clearInterval(idN);
            flagInterval = false;
        }
        noticia++;
        getNoticia(noticia); 
    }


}