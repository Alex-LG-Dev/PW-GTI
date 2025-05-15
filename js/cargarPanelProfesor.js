document.addEventListener('DOMContentLoaded', () => {
    const nombreProfesor = localStorage.getItem('nombreUsuario'); // Solo el nombre

    fetch('../js/AsignaturaProfesor.json')
        .then(response => response.json())
        .then(data => {
            // Filtrar asignaturas del profesor
            const asignaturas = data.filter(asignatura => asignatura.profesor === nombreProfesor);

            // Mostrar hasta 3 asignaturas
            const tarjetasAsignaturas = document.querySelectorAll('.tarjetas-asignaturas li');
            asignaturas.slice(0, 3).forEach((asignatura, i) => {
                const tarjeta = tarjetasAsignaturas[i];
                if (tarjeta) {
                    tarjeta.querySelector('h1').textContent = asignatura.nombre;
                    tarjeta.querySelector('.nombre-profesor').textContent = `Profesor: ${asignatura.profesor}`;
                    tarjeta.querySelector('.tareas-pendientes').textContent = ''; // Opcional
                }
            });

            // Recoger todas las tareas del profesor
            const tareas = asignaturas.flatMap(asignatura => asignatura.Tareas);

            // Mostrar hasta 3 tareas
            const tarjetasTareas = document.querySelectorAll('.tarjetas-tareas li');
            tareas.slice(0, 3).forEach((tarea, i) => {
                const tarjeta = tarjetasTareas[i];
                if (tarjeta) {
                    tarjeta.querySelector('h1').textContent = tarea.nombre;
                    tarjeta.querySelector('.nombre-asignatura').textContent = ''; // Opcional
                    const timeEl = tarjeta.querySelector('time');
                    timeEl.textContent = `Entrega: ${tarea.fecha} ${tarea.hora}`;
                    timeEl.setAttribute('datetime', `${tarea.fecha}T${tarea.hora}`);
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar las asignaturas:', error);
        });
});