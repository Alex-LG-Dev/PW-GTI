function inicializarBotonPublico() {
  const botonPublico = document.getElementById('boton-publico-img');
  const inputPublicada = document.getElementById('publicada');
  if (!botonPublico || !inputPublicada) return;

  const imagen = botonPublico.querySelector('img');

  // Estado inicial según el valor actual del input oculto
  let activo = inputPublicada.value === 'Sí';

  // Establecer la imagen y clase correcta al cargar
  imagen.src = activo
    ? '../img/publico-tarea.png'
    : '../img/privado-tarea.png';
  botonPublico.classList.toggle('activo', activo);

  botonPublico.addEventListener('click', (e) => {
    e.preventDefault(); // evitar comportamiento por defecto

    // Alternar estado
    activo = !activo;

    // Cambiar imagen
    imagen.src = activo
      ? '../img/publico-tarea.png'
      : '../img/privado-tarea.png';

    // Actualizar clase para estilos
    botonPublico.classList.toggle('activo', activo);

    // Actualizar el valor del input oculto
    inputPublicada.value = activo ? 'Sí' : 'No';
  });
}

document.addEventListener('DOMContentLoaded', () => {
  inicializarBotonPublico();
});
