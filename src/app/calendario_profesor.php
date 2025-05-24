<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calendario Profesor</title>
  <link rel="stylesheet" href="css/estilos_souphiane.css" />
  <link rel="stylesheet" href="css/estilos_combinados.css" />
</head>
<body>
    <?php include('encabezadoPROAprofesor.php'); ?>

    <!-- ============================  MIGAS DE PAN  ============================= -->
    <nav class="migas-de-pan">
      <p><a href="home-page-profesor.html">Inicio</a> &gt; <a href="Asignatura_Seleccionada_Tareas_Matematicas_Profesor.html">Matematicas</a> &gt; Tareas</p>
  <!-- ===== CONTENEDOR PRINCIPAL ===== -->
  <div class="calendario-container">

      <!-- ----------  Panel de próximos eventos  ---------- -->
      <aside class="panel-eventos">
          <h3 class="titulo-eventos">Próximos eventos</h3>

        <a href="../app/Asignatura_Seleccionada_Tareas_Matematicas_Profesor.html">

          <div class="tarjeta-evento">
              <span class="fecha-evento">25 may</span>
              <div class="info-evento">
                  <p class="nombre-evento">Tarea 1. Conjuntos y vectores</p>
                  <p class="asignatura-evento">Asignatura: Matemáticas</p>
              </div>
              <img src="../img/icono-tarea.jpg" class="icono-evento" alt="">
          </div>
        </a>
      <a href="../app/Asignatura_Seleccionada_Tareas_Matematicas_Profesor.html">
          <div class="tarjeta-evento">
              <span class="fecha-evento">27 may</span>
              <div class="info-evento">
                  <p class="nombre-evento">Tarea 2. Conjuntos y vectores</p>
                  <p class="asignatura-evento">Asignatura: Matemáticas</p>
              </div>
              <img src="../img/icono-tarea.jpg" class="icono-evento" alt="">
          </div>
        </a>
      </aside>
      <!--  Panel calendario -- -->

      <div class="calendar">
          <div class="calendar-header">
              <button id="prevMonth">&#10094;</button>
              <h2 id="monthYear"></h2>
              <button id="nextMonth">&#10095;</button>
          </div>

          <div class="calendar-grid">
              <div class="day-name">Lun</div><div class="day-name">Mar</div>
              <div class="day-name">Mie</div><div class="day-name">Jue</div>
              <div class="day-name">Vie</div><div class="day-name">Sab</div>
              <div class="day-name">Dom</div>
              <div id="calendarDays" class="calendar-days"></div>
          </div>
      </div>

  </div>
  <!-- Script externo -->
  <script src="../js/calendario.js"></script>
  <script src="../js/nombrecabezera.js"></script>
</body>

</html>

