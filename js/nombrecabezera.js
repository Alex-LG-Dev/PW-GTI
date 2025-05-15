document.addEventListener('DOMContentLoaded', () => {
    const nombreUsuario = localStorage.getItem('nombreUsuario');
    if (nombreUsuario) {
      document.querySelector('.username').textContent = nombreUsuario;
    }
  });