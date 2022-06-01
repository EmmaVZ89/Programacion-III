"use strict";
let idA = 0;
let idB = -1;
let flag = 0;
let idTimeA;
let idTimeB;
let aux_cartaFrontA;
let aux_cartaBackA;
let aux_cartaFrontB;
let aux_cartaBackB;
let sonido1 = new Audio();
sonido1.src = "brillo1.mp3";
let sonido2 = new Audio();
sonido2.src = "brillo2.mp3";
document.getElementsByName("cartaFrontA").forEach((cartaFront) => {
    cartaFront.addEventListener("click", () => {
        if (flag < 2) {
            sonido1.pause();
            if (sonido1.paused) {
                sonido1.play();
            }
            flag++;
            let idCarta = cartaFront.getAttribute("data-id");
            let id = parseInt(idCarta);
            idA = id;
            cartaFront.style.transform = "perspective(600px) rotateY(180deg)";
            const cartaBackA = document.getElementsByName("cartaBackA" + idCarta);
            cartaBackA[0].style.transform = "perspective(600px) rotateY(360deg)";
            aux_cartaFrontA = cartaFront;
            aux_cartaBackA = cartaBackA;
            idTimeA = setTimeout(() => {
                if (idA != idB) {
                    if (aux_cartaFrontB == undefined && aux_cartaBackB == undefined) {
                        cartaFront.style.transform = "perspective(600px) rotateY(0deg)";
                        cartaBackA[0].style.transform = "perspective(600px) rotateY(180deg)";
                    }
                    else {
                        cartaFront.style.transform = "perspective(600px) rotateY(0deg)";
                        cartaBackA[0].style.transform = "perspective(600px) rotateY(180deg)";
                        aux_cartaFrontB.style.transform = "perspective(600px) rotateY(0deg)";
                        aux_cartaBackB[0].style.transform = "perspective(600px) rotateY(180deg)";
                        aux_cartaFrontB = undefined;
                        aux_cartaBackB = undefined;
                    }
                }
                else {
                }
                idA = 0;
                flag--;
                if (flag < 0) {
                    flag = 0;
                }
            }, 2000);
            if (idA == idB) {
                clearTimeout(idTimeA);
                clearTimeout(idTimeB);
                aux_cartaFrontA = undefined;
                aux_cartaBackA = undefined;
                aux_cartaFrontB = undefined;
                aux_cartaBackB = undefined;
                flag = 0;
            }
        }
    });
});
document.getElementsByName("cartaFrontB").forEach((cartaFront) => {
    cartaFront.addEventListener("click", () => {
        if (flag < 2) {
            sonido2.pause();
            if (sonido2.paused) {
                sonido2.play();
            }
            flag++;
            let idCarta = cartaFront.getAttribute("data-id");
            let id = parseInt(idCarta);
            idB = id;
            cartaFront.style.transform = "perspective(600px) rotateY(180deg)";
            const cartaBackB = document.getElementsByName("cartaBackB" + idCarta);
            cartaBackB[0].style.transform = "perspective(600px) rotateY(360deg)";
            aux_cartaFrontB = cartaFront;
            aux_cartaBackB = cartaBackB;
            idTimeB = setTimeout(() => {
                if (idA != idB) {
                    if (aux_cartaFrontA == undefined && aux_cartaBackA == undefined) {
                        cartaFront.style.transform = "perspective(600px) rotateY(0deg)";
                        cartaBackB[0].style.transform = "perspective(600px) rotateY(180deg)";
                    }
                    else {
                        aux_cartaFrontA.style.transform = "perspective(600px) rotateY(0deg)";
                        aux_cartaBackA[0].style.transform = "perspective(600px) rotateY(180deg)";
                        cartaFront.style.transform = "perspective(600px) rotateY(0deg)";
                        cartaBackB[0].style.transform = "perspective(600px) rotateY(180deg)";
                        aux_cartaFrontA = undefined;
                        aux_cartaBackA = undefined;
                    }
                }
                idB = -1;
                flag--;
                if (flag < 0) {
                    flag = 0;
                }
            }, 2000);
            if (idA == idB) {
                clearTimeout(idTimeA);
                clearTimeout(idTimeB);
                aux_cartaFrontA = undefined;
                aux_cartaBackA = undefined;
                aux_cartaFrontB = undefined;
                aux_cartaBackB = undefined;
                flag = 0;
            }
        }
    });
});
//# sourceMappingURL=index.js.map