function loguearGTI(){
    let email = document.getElementById("email").value;
    let contrasena = document.getElementById("contrasena").value;
    
    if (!email || !contrasena) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    fetch('../js/usuariosGTI.json') 
    .then(response => {
        if (!response.ok) {
            throw new Error("No se pudo cargar el archivo JSON");
        }
        return response.json();
    })
    .then(data => {
        const usuarioValido = data.find(u => u.email === email && u.contrasena === contrasena);

        if (usuarioValido) {
            window.location.href = "../app/catalogo_modulos_SiSesion.html";
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
        let password = document.getElementById("contrasena").value;
    
        if (!email || !password) {
            alert("Por favor, complete todos los campos.");
            return;
        }
    
        fetch('../js/usuariosPROA.json') // Ajusta la ruta según tu estructura
            .then(response => {
                if (!response.ok) {
                    throw new Error("No se pudo cargar el archivo JSON");
                }
                return response.json();
            })
            .then(data => {
                const usuarioValido = data.find(u => u.email === email && u.password === password);
    
                if (usuarioValido) {
                    switch (usuarioValido.rol) {
                        case "alumno":
                            window.location.href = "../app/home-page-alumno.html";
                            break;
                        case "profesor":
                            window.location.href = "../app/home-page-professor.html";
                            break;
                        case "pas":
                            window.location.href = "catalogo_modulos_PAS.html";
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
                alert("Hubo un problema al verificar las credenciales. Inténtelo más tarde.");
            });
    }