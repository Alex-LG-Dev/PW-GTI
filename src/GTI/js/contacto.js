

const nombre = document.getElementById("nombreUsuario");
const email = document.getElementById("email");
const motivo = document.getElementById("motivo");
const form = document.getElementById("form");
const parrafo = document.getElementById("warnings");

form.addEventListener("submit", e => {
    e.preventDefault();
    let warnings = "";
    let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    let entrar = false;

    if (nombre.value.length < 2) {
        warnings += `El nombre no es válido <br>`;
        entrar = true;
    }
    if (!regexEmail.test(email.value)) {
        warnings += `El email no es válido <br>`;
        entrar = true;
    }
    if (motivo.value.length < 10) {
        warnings += `El motivo debe tener al menos 10 caracteres <br>`;
        entrar = true;
    }

    if (entrar) {
        parrafo.innerHTML = warnings;
    } else {
        parrafo.innerHTML = "Formulario enviado correctamente";
    }
});