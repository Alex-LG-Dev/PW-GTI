const nombre = document.getElementById("nombreUsuario");
const email = document.getElementById("email");
const contrasena = document.getElementById("contraseña");
const form = document.getElementById("form");
const parrafo = document.getElementById("warnings");

form.addEventListener("submit", e => {
    e.preventDefault();
    let warnings = "";
    let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    let entrar = false;

    if (nombre.value.length < 2) { // Cambiado de nombre.Value a nombre.value
        warnings += `El nombre no es válido <br>`;
        entrar = true;
    }
    if (!regexEmail.test(email.value)) {
        warnings += `El email no es válido <br>`;
        entrar = true;
    }
    if (contrasena.value.length < 8) {
        warnings += `La contraseña no es válida <br>`;
        entrar = true;
    }

    if (entrar) {
        parrafo.innerHTML = warnings;
    } else {
        parrafo.innerHTML = "Se ha registrado correctamente";
    }
});