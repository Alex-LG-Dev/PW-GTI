const calendarDays = document.getElementById("calendarDays");
const monthYear = document.getElementById("monthYear");
const prevBtn = document.getElementById("prevMonth");
const nextBtn = document.getElementById("nextMonth");

const body = document.body;

// 📦 Recuperar dataset
const tareas = JSON.parse(body.dataset.tareas || "[]");
const idAsignatura = parseInt(body.dataset.asignaturaId || "0");
const tareaParaAbrir = body.dataset.tareaOpen || null;

const isProfesor = window.location.href.includes("profesor");
const basePath = isProfesor
  ? "Asignatura_Seleccionada_tareas_Profesor.php"
  : "Asignatura_Seleccionada_tareas_Alumno.php";
const idParam = isProfesor ? "id" : "id_asignatura";

let currentDate = new Date();

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const startDay = firstDay === 0 ? 6 : firstDay - 1;

  calendarDays.innerHTML = "";

  monthYear.textContent = date.toLocaleDateString("es-ES", {
    month: "long",
    year: "numeric",
  });

  for (let i = 0; i < startDay; i++) {
    calendarDays.innerHTML += `<div class="day"></div>`;
  }

  for (let i = 1; i <= daysInMonth; i++) {
    // ✅ Formato de fecha corregido sin toISOString()
    const fechaStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

    const tareasDelDia = tareas.filter((t) => t.date === fechaStr);

    const tareasHtml = tareasDelDia
      .map((tarea) => {
        const shortTitle =
          tarea.titulo.length > 15
            ? tarea.titulo.slice(0, 15) + "…"
            : tarea.titulo;

        return `
          <a 
            href="${basePath}?${idParam}=${tarea.id_asignatura}&open=${tarea.id}" 
            class="task" 
            title="Ir a la tarea"
          >
            ${shortTitle}
          </a>
        `;
      })
      .join("");

    calendarDays.innerHTML += `
      <div class="day ${tareasDelDia.length ? "has-task" : ""}">
        <div class="date">${i}</div>
        ${tareasHtml}
      </div>
    `;
  }
}

prevBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});

nextBtn.addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});

renderCalendar(currentDate);

// 🧱 Modal (opcional)
const modal = document.getElementById("modalCrearTarea");
const cerrarModal = document.getElementById("cerrarModal");
const modalFecha = document.getElementById("modalFecha");

if (modal && modalFecha) {
  calendarDays.addEventListener("click", function (e) {
    const dayDiv = e.target.closest(".day");
    if (!dayDiv || !dayDiv.classList.contains("has-task")) return;

    const dateDiv = dayDiv.querySelector(".date");
    if (!dateDiv) return;

    const day = parseInt(dateDiv.textContent, 10);
    if (isNaN(day)) return;

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth() + 1;
    const fechaStr = `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

    modalFecha.value = fechaStr;
    modal.style.display = "block";
  });

  if (cerrarModal) {
    cerrarModal.onclick = () => (modal.style.display = "none");
  }

  window.onclick = (e) => {
    if (e.target === modal) modal.style.display = "none";
  };
}

// 🌟 Añadir redirección para crear tarea al hacer clic en cualquier día
calendarDays.addEventListener("click", function (e) {
  const dayEl = e.target.closest(".day");
  if (!dayEl || !dayEl.querySelector(".date")) return;

  const dayNumber = parseInt(dayEl.querySelector(".date").textContent, 10);
  if (isNaN(dayNumber)) return;

  const year = currentDate.getFullYear();
  const month = currentDate.getMonth() + 1;

  const fechaStr = `${year}-${String(month).padStart(2, "0")}-${String(dayNumber).padStart(2, "0")}`;

  // Redirigir a crear_tarea.php con la fecha
  const url = `crear_tarea.php?ID_asignatura=${idAsignatura}&fecha=${fechaStr}`;
  window.location.href = url;
});
