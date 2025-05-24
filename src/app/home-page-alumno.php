<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <meta name="description" content="Pagina de Inicio Alumno PROA">
    <link rel="stylesheet" href="css/estilos_combinados.css">
    <title>Panel Alumno PROA</title>
</head>

<body class="body-fondo">
    <!-- ===== Encabezado ===== -->
    <?php include('encabezadoPROAalumno.php'); ?>

    <main>

        <!--imagenes home page-->
        <section class="home-section-logo">
            <img src="../img/Logo-Proa.png" alt="imagen1">
            <p class="p-azul">Tu espacio de estudio digital que acerca a profesores y alumnos.
                Nuestra plataforma digital transforma la enseñanza tradicional en una experiencia interactiva,
                flexible y accesible desde cualquier lugar.</p>
        </section>
        <!--Tarjetas Asignaturas-->
        <section class="home-section-asign">
            <section class="bloque-asignatura" id="asignaturas">
                <header class="texto-2">Ultimas asignaturas visitadas</header>
                <ul class="tarjetas-asignaturas">
                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
                            <article>
                                <header class="titulo-tarea">
                                    <h3>Física</h3>
                                    <img src="../img/icono-asignatura.jpg" alt="">
                                </header>
                                <p class="linksAsignp">Profesor asignatura: Pepe Pereira</p>
                                <p class="linksAsignp">Tareas pendientes: 1</p>
                            </article>
                        </a>
                    </li>


                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
                            <article>
                                <header class="titulo-tarea">
                                    <h3>Física</h3>
                                    <img src="../img/icono-asignatura.jpg" alt="">
                                </header>
                                <p class="linksAsignp">Profesor asignatura: Pepe Pereira</p>
                                <p class="linksAsignp">Tareas pendientes: 1</p>
                            </article>
                        </a>
                    </li>

                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
                            <article>
                                <header class="titulo-tarea">
                                    <h3>Física</h3>
                                    <img src="../img/icono-asignatura.jpg" alt="">
                                </header>
                                <p class="linksAsignp">Profesor asignatura: Pepe Pereira</p>
                                <p class="linksAsignp">Tareas pendientes: 1</p>
                            </article>
                        </a>
                    </li>
                </ul>
            </section>

            <!-- Columna de tareas -->
            <section class="bloque-asignatura" id="tareas">
                <h2 class="texto-2">Tareas próximas a entregar</h2>

                <ul class="tarjetas-tareas">
                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
                            <article>
                                <header class="titulo-tarea">
                                    <h3>Tarea 1. Conjuntos y vectores</h3>
                                    <img src="../img/icono-tarea.jpg" alt="">
                                </header>
                                <p class="linksAsignp">Asignatura: Matemáticas</p>
                                <p class="linksAsignp">Fecha entrega: 17/04/2025 23:55</p>
                            </article>
                        </a>
                    </li>

                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
                            <article>
                                <header class="titulo-tarea">
                                    <h3>Tarea 2. Conceptos y matrices</h3>
                                    <img src="../img/icono-tarea.jpg" alt="">
                                </header>
                                <p class="linksAsignp">Asignatura: Matemáticas</p>
                                <p class="linksAsignp">Fecha entrega: 19/04/2025 23:30</p>
                            </article>
                        </a>
                    </li>

                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Fisica_Alumno.html" class="linksAsign">
                            <article>
                                <header class="titulo-tarea">
                                    <h3>Tarea 3. Campos magnéticos</h3>
                                    <img src="../img/icono-tarea.jpg" alt="">
                                </header>
                                <p class="linksAsignp">Asignatura: Física</p>
                                <p class="linksAsignp">Fecha entrega: 22/04/2025 20:00</p>
                            </article>
                        </a>
                    </li>
                </ul>
            </section>
        </section>
    </main>
    <!-- Script externo -->
    <script src="../js/nombrecabezera.js"></script>
</body>

</html>