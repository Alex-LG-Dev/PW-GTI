const calendarDays = document.getElementById('calendarDays');
const monthYear = document.getElementById('monthYear');
const prevBtn = document.getElementById('prevMonth');
const nextBtn = document.getElementById('nextMonth');

let currentDate = new Date();

// Tareas de ejemplo con URLs
const tareas = [
  { date: '2025-05-25', titulo: 'Tarea 1. Conj.', materia: 'Matemáticas', url: 'tarea1.html' },
  { date: '2025-05-26', titulo: 'Tarea 2. Álgebra', materia: 'Matemáticas', url: 'tarea2.html' }
];

function renderCalendar(date) {
  const year = date.getFullYear();
  const month = date.getMonth();
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const startDay = firstDay === 0 ? 6 : firstDay - 1;

  calendarDays.innerHTML = '';

  monthYear.textContent = date.toLocaleDateString('en-US', {
    month: 'long',
    year: 'numeric'
  });

  // Celdas vacías antes del 1 del mes
  for (let i = 0; i < startDay; i++) {
    calendarDays.innerHTML += `<div class="day"></div>`;
  }

  for (let i = 1; i <= daysInMonth; i++) {
    const fecha = new Date(year, month, i);
    const fechaStr = fecha.toISOString().split('T')[0];

    const tarea = tareas.find(t => t.date === fechaStr);
    const tareaHtml = tarea
      ? `<a href="../app/Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="task" title="Ir a la tarea">${tarea.titulo}<br><small>${tarea.materia}</small></a>`
      : '';

    calendarDays.innerHTML += `
      <div class="day">
        <div class="date">${i}</div>
        ${tareaHtml}
      </div>
    `;
  }
}

prevBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar(currentDate);
});

nextBtn.addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar(currentDate);
});

renderCalendar(currentDate);

// Modal lógica
const modal = document.getElementById('modalCrearTarea');
const cerrarModal = document.getElementById('cerrarModal');
const modalFecha = document.getElementById('modalFecha');

// Delegación de eventos para los días del calendario
calendarDays.addEventListener('click', function(e) {
  const dayDiv = e.target.closest('.day');
  if (!dayDiv) return;
  const dateDiv = dayDiv.querySelector('.date');
  if (!dateDiv) return;

  // Obtener el día seleccionado
  const day = parseInt(dateDiv.textContent, 10);
  if (isNaN(day)) return;

  // Construir la fecha seleccionada
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth() + 1; // 1-based
  const fechaStr = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
  modalFecha.value = fechaStr;

  // Mostrar el modal
  modal.style.display = 'block';
});

// Cerrar modal
cerrarModal.onclick = function() {
  modal.style.display = 'none';
};
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
};
