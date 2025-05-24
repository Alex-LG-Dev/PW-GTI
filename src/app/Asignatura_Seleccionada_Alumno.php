<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROA | Matemáticas</title>

    <!-- Roboto + hoja de estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../app/css/estilos_combinados.css">

    <!-- script (renderiza las tareas) -->
    <script src="../js/code.js" defer></script>
</head>

<body>

<!-- ===============================  CABECERA  =============================== -->
    <?php include('encabezadoPROAalumno.php'); ?>


<!-- ============================  MIGAS DE PAN  ============================= -->
<nav class="migas-de-pan">
  <p><a href="home-page-alumno.html">Inicio</a> &gt; Matematicas</p>
</nav>

<!-- ==========================  CONTENIDO PÁGINA  =========================== -->
<div class="contenedor">
    <!-- Título principal -->
    <h1 class="titulo-asignatura">Matematicas</h1>

    <!-- Pestañas superiores -->
    <div class="pestanas-encabezado">
        <a href="calendario_alumno.html"><button class="pestana">Calendario</button></a>
        <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html"><button class="pestana">Tareas</button></a>
        <button class="pestana activa" onclick="toggleMenuAsignaturas()">Asignaturas</button>
    </div>

    <!-- Columnas -->
    <div class="contenedor-columnas">
        <!-- Columna izquierda – Tareas proximas a entregar -->
        <div class="columna columna-izquierda">
            <h2>Tareas próximas a entregar</h2>
        </div>

        <!-- Columna derecha – estática por ahora -->
        <div class="columna">
            <h2>Tareas calificadas</h2>

            <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
            <div class="tarjeta-tarea">
                <p class="linksAsignp"><strong>Tarea 0. Introducción conjuntos</strong></p>
                <p class="linksAsignp">Asignatura: Matemáticas</p>
                <p class="linksAsignp">Nota: 7.5</p>
            </div>
            </a>

            <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
            <div class="tarjeta-tarea">
                <p class="linksAsignp"><strong>Tarea 0. Introducción conjuntos</strong></p>
                <p class="linksAsignp">Asignatura: Matemáticas</p>
                <p class="linksAsignp">Nota: 7.5</p>
            </div>
            </a>

            <a href="Asignatura_Seleccionada_tareas_Matematicas_Alumno.html" class="linksAsign">
            <div class="tarjeta-tarea">
                <p class="linksAsignp"><strong>Tarea 0. Introducción conjuntos</strong></p>
                <p class="linksAsignp">Asignatura: Matemáticas</p>
                <p class="linksAsignp">Nota: 7.5</p>
            </div>
            </a>
        </div>
    </div>
</div>
<!-- Script externo -->
 <script src="../js/nombrecabezera.js"></script>
 <script src="../js/botonasignaturas.js"></script>
</body>
</html>
