(() => {
  const tareas = document.querySelectorAll(".tarea");
  const urlParams = new URLSearchParams(window.location.search);
  const idOpen = urlParams.get("open");

  const cerrarTodas = () => {
    tareas.forEach(tarea => {
      tarea.classList.remove("abierta");
      const icon = tarea.querySelector(".toggle");
      const detalles = tarea.querySelector(".detalles-tarea");
      if (icon) icon.src = "../img/flecha-abajo.png";
      if (detalles) detalles.classList.add("oculto");
    });
  };

  tareas.forEach(tarea => {
    const header = tarea.querySelector(".clickable-header");
    const detalles = tarea.querySelector(".detalles-tarea");
    const toggleIcon = tarea.querySelector(".toggle");
    const tareaId = tarea.dataset.id;

    const toggleTarea = () => {
      const isOpen = tarea.classList.contains("abierta");
      cerrarTodas();
      if (!isOpen) {
        tarea.classList.add("abierta");
        detalles.classList.remove("oculto");
        if (toggleIcon) toggleIcon.src = "../img/flecha-arriba.png";
      } else {
        if (toggleIcon) toggleIcon.src = "../img/flecha-abajo.png";
      }
    };

    if (header) {
      header.addEventListener("click", e => {
        const noCerrarTags = ["TEXTAREA", "BUTTON", "INPUT", "LABEL"];
        if (noCerrarTags.includes(e.target.tagName)) return;
        toggleTarea();
      });
    }

    if (idOpen && tareaId === idOpen) {
      setTimeout(() => {
        tarea.classList.add("abierta");
        detalles.classList.remove("oculto");
        if (toggleIcon) toggleIcon.src = "../img/flecha-arriba.png";

        // Hacer scroll hasta la tarea abierta
        tarea.scrollIntoView({ behavior: "smooth", block: "center" });
      }, 200);
    }
  });
})();
