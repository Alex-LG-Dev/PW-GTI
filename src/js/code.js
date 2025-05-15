function loguearGTI() {
    let email = document.getElementById("email").value;
    let contrasena = document.getElementById("contrasena").value;

    // Validar que los campos no estén vacíos
    if (!email || !contrasena) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    // Cargar el archivo JSON de usuarios
    fetch('../js/usuariosGTI.json')
        .then(response => {
            if (!response.ok) {
                throw new Error("No se pudo cargar el archivo JSON");
            }
            return response.json();
        })
        .then(data => {
            // Buscar el usuario por email y contraseña
            const usuarioValido = data.find(u => u.email === email && u.contrasena === contrasena);

            if (usuarioValido) {
                // Guardar el nombre completo del usuario en localStorage
                const nombreUsuarioLogin = `${usuarioValido.nombre} ${usuarioValido.apellido}`;
                localStorage.setItem('nombreUsuario', nombreCompleto);
                // Redirigir a la página de inicio
                window.location.href = "../app/HomepageGTI.html";
            } else {
                alert("Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.");
            }
        })
        .catch(error => {
            console.error("Error al cargar el archivo JSON:", error);
            alert("Hubo un problema al verificar las credenciales. Inténtelo más tarde.");
        });
}


   
function loguearPROA() {
    let email = document.getElementById("usuario").value;
    let contrasena = document.getElementById("contrasena").value;

    // Validar que los campos no estén vacíos
    if (!email) {
        alert("Por favor, ingrese su correo electrónico.");
        return;
    }
    if (!contrasena) {
        alert("Por favor, ingrese su contraseña.");
        return;
    }

    // Cargar el archivo JSON de usuarios
    fetch('../js/usuariosPROA.json') // Ajusta la ruta según tu estructura
        .then(response => {
            if (!response.ok) {
                throw new Error("No se pudo cargar el archivo JSON");
            }
            return response.json();
        })
        .then(data => {
            // Buscar el usuario por email y contraseña
            const usuarioValido = data.find(u => u.email === email && u.password === contrasena);

            if (usuarioValido) {
                // Guardar el nombre completo del usuario en localStorage
                const nombreCompleto = `${usuarioValido.nombre}`;
                localStorage.setItem('nombreUsuario', nombreCompleto);

                // Redirigir según el rol del usuario
                switch (usuarioValido.rol) {
                    case "alumno":
                        window.location.href = "../app/home-page-alumno.html";
                        break;
                    case "profesor":
                        window.location.href = "../app/home-page-professor.html";
                        break;
                    case "pas":
                        window.location.href = "../app/catalogo_modulos_PAS.html";
                        break;
                    default:
                        alert("Rol no reconocido. Contacte con el administrador.");
                }
            } else {
                alert("Usuario o contraseña incorrectos. Por favor, inténtelo de nuevo.");
            }
        })
        .catch(error => {
            console.error("Error al cargar el archivo JSON:", error);
            alert("No se pudo cargar la información de usuarios. Por favor, inténtelo más tarde.");
        });
}
/* =========================================================
   MOSTRAR TAREAS DEL PROFESOR  –  versión definitiva
   ========================================================= */
function mostrarTareasProfesor() {

    /* 1) Nombre guardado al hacer login */
    const nombreCompleto = localStorage.getItem("nombreUsuario") || "";
    if (!nombreCompleto) { console.warn("Sin profesor logueado"); return; }

    /* Solo el primer nombre:  "Kevan Pounds" → "Kevan" */
    const nombreCorto = nombreCompleto.trim().split(" ")[0];

    /* 2) Contenedor donde insertaremos las tarjetas */
    const columna = document.querySelector(".columna-izquierda");
    if (!columna) { console.error("No se encontró .columna-izquierda"); return; }

    /* 3) Cargar el JSON de asignaturas/tareas */
    fetch("../js/AsignaturaProfesor.json")
        .then(r => r.json())
        .then(asignaturas => {

            /* 4) Filtrar solo las asignaturas del profesor */
            const propias = asignaturas.filter(a => a.profesor === nombreCorto);

            /* 5) Limpiar y añadir título */
            columna.innerHTML = "<h2>Tareas próximas a entregar</h2>";

            if (!propias.length) {
                columna.insertAdjacentHTML("beforeend",
                    "<p>No hay tareas próximas para este profesor.</p>");
                return;
            }

            /* 6) Pintar cada tarea ordenada por fecha-hora */
            propias.forEach(asig => {
                [...asig.Tareas]
                    .sort((a,b) => new Date(`${a.fecha}T${a.hora}`) -
                                    new Date(`${b.fecha}T${b.hora}`))
                    .forEach(t => {
                        columna.insertAdjacentHTML("beforeend", `
                            <div class="tarjeta-tarea">
                                <p class="fecha-entrega"><strong>Fecha entrega: ${t.fecha} ${t.hora}</strong></p>
                                <p>Asignatura: ${asig.nombre}</p>
                                <p class="titulo-tarea">${t.nombre}</p>
                                <p>${t.descripcion}</p>
                            </div>`);
                    });
            });
        })
        .catch(err => console.error("Error al cargar tareas:", err));
}

/* Ejecuta al cargar la página */
document.addEventListener("DOMContentLoaded", mostrarTareasProfesor);
/* =====================================================================
   1. ACORDEÓN DE TAREAS
   ===================================================================== */
document.querySelectorAll('.tarea').forEach(tarjeta => {
  const cabecera  = tarjeta.querySelector('.contenedor-tarea-header');
  const detalles  = tarjeta.querySelector('.detalles-tarea');
  const flechaImg = tarjeta.querySelector('.toggle');

  cabecera.addEventListener('click', () => {
    detalles.classList.toggle('oculto');   // muestra u oculta el bloque
    flechaImg.classList.toggle('girar');   // rota la flecha
  });
});

/* =====================================================================
   2. FILTRO POR TEXTO (“Buscar tarea”)
   ===================================================================== */
const buscador = document.getElementById('buscador-tarea');

buscador.addEventListener('input', () => {
  const termino = buscador.value.toLowerCase();

  document.querySelectorAll('.tarea').forEach(tarjeta => {
    const titulo = tarjeta.querySelector('h2').textContent.toLowerCase();
    tarjeta.style.display = titulo.includes(termino) ? 'block' : 'none';
  });
});
/* =====================================================================
   ACORDEÓN DE TARJETAS
   ===================================================================== */
document.querySelectorAll('.tarea').forEach(tarjeta => {
  const flechaImg = tarjeta.querySelector('.toggle');
  const detalles = tarjeta.querySelector('.detalles-tarea');
  const textarea = tarjeta.querySelector('textarea');
  const formulario = tarjeta.querySelector('.responder-tarea');

  // Event listener para el icono de flecha
  flechaImg.addEventListener('click', (event) => {
    event.stopPropagation();
    toggleDetalles();
  });

  // Event listener para el textarea
  if (textarea) {
    textarea.addEventListener('click', (event) => {
      event.stopPropagation();
    });
  }

  // Event listener para el envío del formulario
  if (formulario) {
    formulario.addEventListener('submit', (event) => {
      event.preventDefault(); // Previene el envío tradicional del formulario
      
      // Crear elemento de alerta
      const alertaElement = document.createElement('div');
      alertaElement.className = 'warning';
      alertaElement.textContent = 'La Respuesta se ha enviado correctamente';
      document.body.appendChild(alertaElement);
      
      // Remover la alerta después de 2 segundos
      setTimeout(() => {
          alertaElement.remove();
      }, 2000);
      
      formulario.reset(); // Limpia el formulario después del envío
    });
  }

  // Función para toggle
  function toggleDetalles() {
    detalles.classList.toggle('oculto');   
    flechaImg.classList.toggle('girar');   
  }
});
