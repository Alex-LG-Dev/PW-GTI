const titulo = document.getElementById("titulo");
const fecha = document.getElementById("fecha");
const hora = document.getElementById("hora");
const descripcion = document.getElementById("descripcion");
const form = document.getElementById("form");
const parrafo = document.getElementById("warnings");

form.addEventListener("submit", e => {
    e.preventDefault();
    let warnings = "";
    let entrar = false;

    if (titulo.value.length < 2) {
        warnings += `El nombre no es válido <br>`;
        entrar = true;
    }
    
    if (entrar) {
        parrafo.innerHTML = warnings;
    } else {
        parrafo.innerHTML = "Tarea creada correctamente";
    }
});