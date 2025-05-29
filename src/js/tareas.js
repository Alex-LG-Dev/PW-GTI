const tareas = document.querySelectorAll('.tarea');

tareas.forEach(tarea => {
  const header = tarea.querySelector('.contenedor-tarea-header');
  const icono = header.querySelector('.toggle');
  const detalles = tarea.querySelector('.detalles-tarea');

  const toggleTarea = () => {
    detalles.classList.toggle('oculto');
    const nuevaRuta = detalles.classList.contains('oculto') 
      ? '../img/flecha-abajo.png' 
      : '../img/flecha-arriba.png';
    icono.src = nuevaRuta;
  };

  // Permite abrir con clic en header completo (incluyendo icono)
  header.addEventListener('click', (e) => {
    // Ignorar clicks dentro de campos de texto o formularios
    if (e.target.tagName === 'TEXTAREA' || e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON') {
      return;
    }
    toggleTarea();
  });
});
