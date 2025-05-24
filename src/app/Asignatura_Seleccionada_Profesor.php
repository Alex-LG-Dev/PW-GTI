<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROA | Matemáticas</title>

    <!-- Roboto + hoja de estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos_combinados.css">

    <!-- script (renderiza las tareas) -->
    <script src="../js/code.js" defer></script>
    <script src="../js/nombrecabezera.js" defer></script>
    <script src="../js/botonasignaturas.js" defer></script>
</head>

<body class="body-fondo">
  <!-- ===============================  CABECERA  =============================== -->
    <?php include('encabezadoPROAprofesor.php'); ?>


    <!-- ============================  MIGAS DE PAN  ============================= -->
    <nav class="migas-de-pan">
        <p><a href="home-page-profesor.php">Inicio</a> &gt; Matematicas</p>
    </nav>

   
    <!-- ==========================  CONTENIDO PÁGINA  =========================== -->
    <div class="contenedor">
        <!-- Título principal -->
        <h1 class="titulo-asignatura">Matematicas</h1>

        <!-- Pestañas superiores -->
        <div class="pestanas-encabezado">
            <a href="calendario_profesor.php"><button class="pestana">Calendario</button></a>
            <a href="Asignatura_Seleccionada_tareas_Profesor.php"><button class="pestana">Tareas</button></a>
            <button class="pestana activa" onclick="toggleMenuAsignaturas()">Asignaturas</button>
        </div>

        <!--Tarjetas Asignaturas-->
        <section class="home-section-asign">
            <section class="bloque-asignatura" id="asignaturas">
                <header class="texto-2">Tareas proximas a entregar</header>
                <ul class="tarjetas-asignaturas">
                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Profesor.php" class="linksAsign">
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
                        <a href="Asignatura_Seleccionada_tareas_Profesor.php" class="linksAsign">
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
                        <a href="Asignatura_Seleccionada_tareas_Profesor.php" class="linksAsign">
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
                <button class="pestana activa" onclick="toggleMenuAsignaturas()">Ver todas las Asignaturas</button>
            </section>

            <!-- Columna de tareas -->
            <section class="bloque-asignatura" id="asignaturas">
                <h2 class="texto-2">Tareas calificadas</h2>

                <ul class="tarjetas-asignaturas">
                    <li>
                        <a href="Asignatura_Seleccionada_tareas_Profesor.php" class="linksAsign">
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
                        <a href="Asignatura_Seleccionada_tareas_Profesor.php" class="linksAsign">
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
                        <a href="Asignatura_Seleccionada_tareas_Profesor.php" class="linksAsign">
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
                <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Profesor.php'">Ver todas las Tareas</button>
            </section>
        </section>
        </main>


</html>