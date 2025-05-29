  const headers = document.querySelectorAll('.tarea');

  headers.forEach(header => {
    header.addEventListener('click', () => {
      const card = header.parentElement;
      const details = card.querySelector('.detalles-tarea');
      const icon = header.querySelector('.toggle');

      const isHidden = details.classList.toggle('oculto');
      icon.src = isHidden ? '../img/flecha-abajo.png' : '../img/flecha-arriba.png';
      icon.alt = isHidden ? 'Mostrar detalles' : 'Ocultar detalles';
    });
  });
