function inicializarBotonPublico() {
  const botonPublico = document.getElementById('boton-publico-img');
  if (!botonPublico) return; // por si no existe el botón

  const imagen = botonPublico.querySelector('img');
  let activo = true; // estado inicial: público

  botonPublico.addEventListener('click', (e) => {
    e.preventDefault(); // evitar el envío del formulario o recarga

    activo = !activo;
    imagen.src = activo
      ? '../img/publico-tarea.png'
      : '../img/privado-tarea.png';

    botonPublico.classList.toggle('activo', activo);
  });
}
// Llamar a esta función cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  inicializarBotonPublico();
});