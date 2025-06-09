(() => {
  const tareas = document.querySelectorAll(".tarea");

  const cerrarTodas = () => {
    tareas.forEach(tarea => {
      tarea.classList.remove("abierta");
      const icon = tarea.querySelector(".toggle");
      const detalles = tarea.querySelector(".detalles-tarea");
      if (icon) icon.src = "../img/flecha_abajo.png";
      if (detalles) detalles.classList.add("oculto");
    });
  };

  tareas.forEach(tarea => {
    const header = tarea.querySelector(".contenedor-tarea-header");
    const detalles = tarea.querySelector(".detalles-tarea");
    const toggleIcon = tarea.querySelector(".toggle");

    const toggleTarea = () => {
      const isOpen = tarea.classList.contains("abierta");
      cerrarTodas();
      if (!isOpen) {
        tarea.classList.add("abierta");
        detalles.classList.remove("oculto");
        if (toggleIcon) toggleIcon.src = "../img/flecha_arriba.png";
      } else {
        if (toggleIcon) toggleIcon.src = "../img/flecha_abajo.png";
      }
    };

    if (header) {
      header.addEventListener("click", e => {
        if (["TEXTAREA", "BUTTON", "INPUT", "LABEL"].includes(e.target.tagName)) return;
        toggleTarea();
      });
    }
  });
})();

    if (idOpen && tareaId === idOpen) {
      setTimeout(() => {
        tarea.classList.add("abierta");
        detalles.classList.remove("oculto");
        if (toggleIcon) toggleIcon.src = "../img/flecha_arriba.png";
// === FUNCIONES DE FILTRO ===

let estadoActual = null;
let nombreFiltro = "";
let fechaFiltro = "";

// 🔤 Función para normalizar (quita tildes y pone en minúsculas)
function normalizarTexto(texto) {
  return texto
    .normalize("NFD") // separa caracteres y acentos
    .replace(/[\u0300-\u036f]/g, "") // elimina los acentos
    .toLowerCase()
    .trim();
}

// Botones de estado
document.querySelectorAll('.filtro-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activa'));
    btn.classList.add('activa');
    estadoActual = btn.dataset.estado;
    aplicarFiltros();
  });
});

// Buscador por nombre con normalización
document.getElementById('filtro-nombre').addEventListener('input', function () {
  nombreFiltro = normalizarTexto(this.value);
  aplicarFiltros();
});

// Filtro por fecha
document.getElementById('filtro-fecha').addEventListener('input', function () {
  fechaFiltro = this.value;
  aplicarFiltros();
});

// Filtro combinado
function aplicarFiltros() {
  document.querySelectorAll('.tarea').forEach(card => {
    const estado = card.dataset.estado ?? "";
    const nombre = card.dataset.nombre ?? "";
    const fecha = (card.dataset.fecha || "").substring(0, 10);

    const matchEstado = !estadoActual || estado === estadoActual;
    const matchNombre = normalizarTexto(nombre).includes(nombreFiltro);
    const matchFecha = !fechaFiltro || fecha.startsWith(fechaFiltro);

    card.style.display = (matchEstado && matchNombre && matchFecha) ? "block" : "none";
  });
}

// Mostrar todo al cargar
document.addEventListener("DOMContentLoaded", aplicarFiltros);
