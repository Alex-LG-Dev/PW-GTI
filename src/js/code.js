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
                const nombreCompleto = `${usuarioValido.nombre} ${usuarioValido.apellido}`;
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

function registrogti() {
    let nombreUsuario = document.getElementById("nombreUsuario").value.trim();
    let email = document.getElementById("email").value.trim();
    let contrasena = document.getElementById("contraseña").value.trim();
    
    // Validar que todos los campos estén completos
    if (!nombreUsuario || !email || !contrasena) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    // Mostrar mensaje de éxito
    alert("El registro se ha realizado correctamente.");
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
                const nombreCompleto = `${usuarioValido.nombre} ${usuarioValido.apellido1} ${usuarioValido.apellido2 || ''}`.trim();
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
/* ===== Toggle menú hamburguesa ===== */
window.addEventListener('DOMContentLoaded', () => {
  const btnHamburger = document.querySelector('.hamburger');
  const divHeader    = document.querySelector('.div-header');
  if (!btnHamburger || !divHeader) return;

  btnHamburger.addEventListener('click', () => {
    divHeader.classList.toggle('active');
    const abierto = divHeader.classList.contains('active');
    btnHamburger.setAttribute('aria-expanded', String(abierto));
  });
});