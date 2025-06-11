(() => {
  // Filtro curso
  const filtroCursoBtns = document.querySelectorAll(".filtro-btn");
  const secciones = document.querySelectorAll(".seccion-curso");

  let cursoActivo = null;

  filtroCursoBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      const curso = btn.dataset.curso;

      // Toggle: si ya está activo, quita
      if (cursoActivo === curso) {
        cursoActivo = null;
        btn.classList.remove("activo");
        secciones.forEach(sec => sec.style.display = "block");
      } else {
        cursoActivo = curso;
        filtroCursoBtns.forEach(b => b.classList.remove("activo"));
        btn.classList.add("activo");

        secciones.forEach(sec => {
          const cursoSec = sec.dataset.curso;
          sec.style.display = (cursoSec === curso) ? "block" : "none";
        });
      }
    });
  });

  // Filtro nombre
  const inputNombre = document.getElementById("filtro-nombre");
  if (inputNombre) {
    inputNombre.addEventListener("input", () => {
      const valor = inputNombre.value.toLowerCase().trim();
      const tarjetas = document.querySelectorAll(".tarjeta-asignatura");

      tarjetas.forEach(card => {
        const nombre = card.dataset.nombre;
        card.style.display = nombre.includes(valor) ? "block" : "none";
      });
    });
  }

  // Toggle visibilidad por curso
  document.querySelectorAll(".boton-toggle-curso").forEach(boton => {
    boton.addEventListener("click", () => {
      const contenedor = boton.closest(".seccion-curso");
      const tarjetas = contenedor.querySelector(".contenedor-tarjetas");

      tarjetas.classList.toggle("oculto");

      const flecha = tarjetas.classList.contains("oculto") ? "▼" : "▲";
      boton.textContent = flecha;
    });
  });
})();
