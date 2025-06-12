// tareas.js

(() => {
  // 1) Capturo las tareas y estado de filtros
  const tareas = document.querySelectorAll(".tarea");
  let estadoActual = null,
      nombreFiltro = "",
      fechaFiltro = "";

  // 2) Normalizador de texto
  function normalizarTexto(texto) {
    return texto
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .toLowerCase()
      .trim();
  }

  // 3) Función de filtrado
  function aplicarFiltros() {
    tareas.forEach((card) => {
      const estado = card.dataset.estado || "";
      const nombre = card.dataset.nombre || "";
      const fecha = (card.dataset.fecha || "").substring(0, 10);

      const okEstado = !estadoActual || estado === estadoActual;
      const okNombre = normalizarTexto(nombre).includes(nombreFiltro);
      const okFecha  = !fechaFiltro || fecha.startsWith(fechaFiltro);

      card.style.display = okEstado && okNombre && okFecha
        ? "block"
        : "none";
    });
  }

// 4) Bind de filtros de estado (botones)
document.querySelectorAll(".filtro-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    const estadoBtn = btn.dataset.estado;

    // Toggle: si ya está activo, desactiva
    if (estadoActual === estadoBtn) {
      estadoActual = null;
      btn.classList.remove("activa");
    } else {
      estadoActual = estadoBtn;
      document.querySelectorAll(".filtro-btn").forEach((b) => b.classList.remove("activa"));
      btn.classList.add("activa");
    }

    aplicarFiltros();
  });
});


  // 5) Bind de filtro por nombre
  const inputNombre = document.getElementById("filtro-nombre");
  if (inputNombre) {
    inputNombre.addEventListener("input", function () {
      nombreFiltro = normalizarTexto(this.value);
      aplicarFiltros();
    });
  }

  // 6) Bind de filtro por fecha
  const inputFecha = document.getElementById("filtro-fecha");
  if (inputFecha) {
    inputFecha.addEventListener("input", function () {
      fechaFiltro = this.value;
      aplicarFiltros();
    });
  }

  // 7) Toggle de abrir/cerrar detalle
  const cerrarTodas = () => {
    tareas.forEach((t) => {
      t.classList.remove("abierta");
      const icon = t.querySelector(".toggle");
      const det  = t.querySelector(".detalles-tarea");
      det?.classList.add("oculto");
      if (icon) icon.src = "../img/flecha_abajo.png";
    });
  };
  tareas.forEach((tarea) => {
    const header   = tarea.querySelector(".contenedor-tarea-header");
    const detalles = tarea.querySelector(".detalles-tarea");
    const icon     = tarea.querySelector(".toggle");

    if (header) {
      header.addEventListener("click", (e) => {
        if (["TEXTAREA","BUTTON","INPUT","LABEL"].includes(e.target.tagName))
          return;
        const abierta = tarea.classList.contains("abierta");
        cerrarTodas();
        if (!abierta) {
          tarea.classList.add("abierta");
          detalles?.classList.remove("oculto");
          if (icon) icon.src = "../img/flecha_arriba.png";
        }
      });
    }
  });

  // 8) Abrir tarea desde ?open=ID (si aplica)
  const idOpen = document.body.dataset.tareaOpen;
  if (idOpen) {
    const sel = `.tarea[data-id="${idOpen}"]`;
    const tareaParaAbrir = document.querySelector(sel);
    if (tareaParaAbrir) {
      const det = tareaParaAbrir.querySelector(".detalles-tarea");
      const ic  = tareaParaAbrir.querySelector(".toggle");
      tareaParaAbrir.classList.add("abierta");
      det?.classList.remove("oculto");
      if (ic) ic.src = "../img/flecha_arriba.png";
    }
  }

  // 9) Primera pasada de filtros
  aplicarFiltros();
})();
const botonesFiltro = document.querySelectorAll(".filtro-btn");
const tareas = document.querySelectorAll(".tarea");
let filtroActivo = null;

botonesFiltro.forEach(boton => {
  boton.addEventListener("click", () => {
    const estado = boton.getAttribute("data-estado");

    // Si el filtro ya está activo, lo quitamos
    if (filtroActivo === estado) {
      filtroActivo = null;
      boton.classList.remove("activo");
      tareas.forEach(t => t.style.display = "block");
    } else {
      filtroActivo = estado;
      botonesFiltro.forEach(b => b.classList.remove("activo"));
      boton.classList.add("activo");

      tareas.forEach(t => {
        const estadoTarea = t.getAttribute("data-estado");
        t.style.display = (estadoTarea === estado) ? "block" : "none";
      });
    }
  });
});
const mensaje = document.getElementById('mensaje-exito');
  if (mensaje) {
    setTimeout(() => {
      mensaje.style.transition = 'opacity 0.5s ease';
      mensaje.style.opacity = '0';
      setTimeout(() => mensaje.remove(), 500);
    }, 4000);
  }
setTimeout(function () {
  const creado = document.getElementById('mensaje-exito');
  const eliminado = document.getElementById('mensaje-eliminado');
  if (creado) creado.remove();
  if (eliminado) eliminado.remove();
}, 3000);