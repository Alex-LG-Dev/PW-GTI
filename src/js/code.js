/* =========================================================
   code.js  –  Gestión de login, interfaz y calificación
   ========================================================= */

/* ---------------------------------------------------------
   0. Helper genérico para mostrar avisos (clase .warning)
   --------------------------------------------------------- */
function mostrarAviso(texto){
  const aviso = document.createElement('div');
  aviso.className = 'warning'; // usa los estilos ya definidos en CSS
  aviso.textContent = texto;
  document.body.appendChild(aviso);
  setTimeout(() => aviso.remove(), 2000);
}

/* =========================================================
   1. LOGIN GTI
   ========================================================= */
function loguearGTI(){
  const email      = document.getElementById('email').value.trim();
  const contrasena = document.getElementById('contrasena').value.trim();

  if(!email || !contrasena){ mostrarAviso('Por favor, complete todos los campos.'); return; }

  fetch('../js/usuariosGTI.json')
    .then(r => { if(!r.ok) throw new Error('No se pudo cargar el archivo JSON'); return r.json(); })
    .then(users => {
      const ok = users.find(u => u.email === email && u.contrasena === contrasena);
      if(!ok){ mostrarAviso('Usuario o contraseña incorrectos.'); return; }
      localStorage.setItem('nombreUsuario', `${ok.nombre} ${ok.apellido}`);
      window.location.href = '../app/HomepageGTI.html';
    })
    .catch(err => { console.error(err); mostrarAviso('Hubo un problema. Inténtelo más tarde.'); });
}

/* =========================================================
   2. LOGIN PROA
   ========================================================= */
function loguearPROA(){
  const email      = document.getElementById('usuario').value.trim();
  const contrasena = document.getElementById('contrasena').value.trim();

  if(!email ){ mostrarAviso('Por favor, ingrese su correo.'); return; }
  if(!contrasena){ mostrarAviso('Por favor, ingrese su contraseña.'); return; }

  fetch('../js/usuariosPROA.json')
    .then(r => { if(!r.ok) throw new Error('No se pudo cargar el archivo JSON'); return r.json(); })
    .then(users => {
      const ok = users.find(u => u.email === email && u.password === contrasena);
      if(!ok){ mostrarAviso('Usuario o contraseña incorrectos.'); return; }
      localStorage.setItem('nombreUsuario', `${ok.nombre}`);
      switch(ok.rol){
        case 'alumno':   window.location.href = '../app/home-page-alumno.html';     break;
        case 'profesor': window.location.href = '../app/home-page-professor.html';  break;
        case 'pas':      window.location.href = '../app/catalogo_modulos_PAS.html'; break;
        default:         mostrarAviso('Rol no reconocido.');
      }
    })
    .catch(err => { console.error(err); mostrarAviso('No se pudo cargar la información.'); });
}

/* =========================================================
   3. MOSTRAR TAREAS DEL PROFESOR  (sidebar home–profesor)
   ========================================================= */
function mostrarTareasProfesor(){
  const nombreCompleto = localStorage.getItem('nombreUsuario') || '';
  if(!nombreCompleto) return;
  const nombreCorto = nombreCompleto.split(' ')[0];
  const columna     = document.querySelector('.columna-izquierda');
  if(!columna) return;

  fetch('../js/AsignaturaProfesor.json')
    .then(r => r.json())
    .then(asignaturas => {
      const propias = asignaturas.filter(a => a.profesor === nombreCorto);
      columna.innerHTML = '<h2>Tareas próximas a entregar</h2>';
      if(!propias.length){ columna.insertAdjacentHTML('beforeend','<p>No hay tareas próximas.</p>'); return; }

      propias.forEach(asig => {
        [...asig.Tareas]
          .sort((a,b)=> new Date(`${a.fecha}T${a.hora}`) - new Date(`${b.fecha}T${b.hora}`))
          .forEach(t => {
            columna.insertAdjacentHTML('beforeend',`
              <div class="tarjeta-tarea">
                <p class="fecha-entrega"><strong>Fecha entrega: ${t.fecha} ${t.hora}</strong></p>
                <p>Asignatura: ${asig.nombre}</p>
                <p class="titulo-tarea">${t.nombre}</p>
                <p>${t.descripcion}</p>
              </div>`);
          });
      });
    })
    .catch(err => console.error('Error cargando tareas:', err));
}

/* =========================================================
   4. INICIALIZAR CALIFICACIÓN DE TAREAS
   ========================================================= */
function initCalificarTareas(){
  /* 4.1  ▲  Manejador para el botón "Asignar nota" */
  document.querySelectorAll('.nota-wrapper .btn-asignar').forEach(btn => {
    btn.addEventListener('click', () => {
      const wrapper = btn.closest('.nota-wrapper');
      const input   = wrapper?.querySelector('input[type="number"]');
      const valor   = (input?.value || '').trim();

      if(!valor){                     // campo vacío
        mostrarAviso('Por favor, complete la nota.');
        return;
      }

      // aquí iría la lógica de guardado / fetch si la hay…
      mostrarAviso('Nota asignada correctamente.');
    });
  });
}

/* =========================================================
   5. BUSCADOR DE TAREAS  (si existe el input)
   ========================================================= */
function initFiltroTareas(){
  const buscador = document.getElementById('buscador-tarea');
  if(!buscador) return;
  buscador.addEventListener('input', () => {
    const termino = buscador.value.toLowerCase();
    document.querySelectorAll('.tarea').forEach(t => {
      const titulo = t.querySelector('h2')?.textContent.toLowerCase() || '';
      t.style.display = titulo.includes(termino)? 'block':'none';
    });
  });
}

/* =========================================================
   6. ARRANQUE GLOBAL
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {
  mostrarTareasProfesor();   // sidebar home profesor
  initCalificarTareas();     // página calificar tareas
  initFiltroTareas();        // buscador de tareas
});
