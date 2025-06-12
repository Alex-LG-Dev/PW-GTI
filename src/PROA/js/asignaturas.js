(() => {
  // === Filtro por curso ===
  const botonesFiltro = document.querySelectorAll(".btn-curso-filtro");
  const bloquesCurso = document.querySelectorAll(".bloque-curso-asignaturas");

  let cursoActivo = null;

  botonesFiltro.forEach(boton => {
    boton.addEventListener("click", () => {
      const curso = boton.dataset.curso;

      if (cursoActivo === curso) {
        // Desactivar filtro
        cursoActivo = null;
        boton.classList.remove("activa");

        // Mostrar todos los cursos y colapsarlos
        bloquesCurso.forEach(sec => {
          sec.style.display = "block";
          const tarjetas = sec.querySelector(".tarjetas-curso-asignatura");
          const toggleBtn = sec.querySelector(".btn-toggle-curso");
          const img = toggleBtn ? toggleBtn.querySelector("img") : null;
          if (tarjetas) tarjetas.classList.add("oculto");
          if (img) {
            img.src = "../img/flecha_abajo.png";
            img.alt = "Mostrar";
          }
        });

      } else {
        // Activar filtro
        cursoActivo = curso;
        botonesFiltro.forEach(b => b.classList.remove("activa"));
        boton.classList.add("activa");

        bloquesCurso.forEach(sec => {
          const cursoSec = sec.dataset.curso;
          const mostrar = cursoSec === curso;

          sec.style.display = mostrar ? "block" : "none";

          const tarjetas = sec.querySelector(".tarjetas-curso-asignatura");
          const toggleBtn = sec.querySelector(".btn-toggle-curso");
          const img = toggleBtn ? toggleBtn.querySelector("img") : null;

          if (tarjetas && toggleBtn && img) {
            if (mostrar) {
              tarjetas.classList.remove("oculto");
              img.src = "../img/flecha_arriba.png";
              img.alt = "Ocultar";
            } else {
              tarjetas.classList.add("oculto");
              img.src = "../img/flecha_abajo.png";
              img.alt = "Mostrar";
            }
          }
        });
      }
    });
  });

  // === Filtro por nombre ===
  const inputNombre = document.getElementById("filtro-nombre");
  if (inputNombre) {
    inputNombre.addEventListener("input", () => {
      const valor = inputNombre.value.toLowerCase().trim();
      const tarjetas = document.querySelectorAll(".tarjeta-asignatura-alumno");

      tarjetas.forEach(card => {
        const nombre = card.dataset.nombre;
        card.style.display = nombre.includes(valor) ? "block" : "none";
      });
    });
  }

  // === Toggle plegable por curso (manual) ===
  document.querySelectorAll(".btn-toggle-curso").forEach(boton => {
    boton.addEventListener("click", () => {
      const contenedor = boton.closest(".contenedor-curso-centrado");
      const tarjetas = contenedor.querySelector(".tarjetas-curso-asignatura");
      const img = boton.querySelector("img");

      tarjetas.classList.toggle("oculto");
      if (img) {
        img.src = tarjetas.classList.contains("oculto")
          ? "../img/flecha_abajo.png"
          : "../img/flecha_arriba.png";
        img.alt = tarjetas.classList.contains("oculto")
          ? "Mostrar"
          : "Ocultar";
      }
    });
  });

  // === Toggle al hacer click en el bloque (excepto en elementos interactivos) ===
  document.querySelectorAll(".contenedor-curso-centrado").forEach(bloque => {
    bloque.addEventListener("click", (e) => {
      const esElementoInteractivo = e.target.closest("button, a, .tarjeta-asignatura-alumno");
      if (esElementoInteractivo) return;

      const tarjetas = bloque.querySelector(".tarjetas-curso-asignatura");
      const toggleBtn = bloque.querySelector(".btn-toggle-curso");
      const img = toggleBtn ? toggleBtn.querySelector("img") : null;

      if (!tarjetas || !toggleBtn || !img) return;

      tarjetas.classList.toggle("oculto");
      img.src = tarjetas.classList.contains("oculto")
        ? "../img/flecha_abajo.png"
        : "../img/flecha_arriba.png";
      img.alt = tarjetas.classList.contains("oculto")
        ? "Mostrar"
        : "Ocultar";
    });
  });
})();
