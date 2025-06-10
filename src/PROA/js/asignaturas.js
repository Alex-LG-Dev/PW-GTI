document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.clickable-curso').forEach(header => {
    header.addEventListener('click', () => {
      const lista = header.nextElementSibling;       // el <ul>
      const flecha = header.querySelector('.toggle-curso');
      const abierto = !lista.classList.contains('oculto');

      if (abierto) {
        // colapsar
        lista.classList.add('oculto');
        flecha.src = '../img/flecha_abajo.png';
        header.classList.remove('abierto');
      } else {
        // desplegar
        lista.classList.remove('oculto');
        flecha.src = '../img/flecha_arriba.png';
        header.classList.add('abierto');
      }
    });
  });
});
