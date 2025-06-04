<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calendario Alumno</title>
  <link rel="stylesheet" href="css/estilos_souphiane.css" />
  <link rel="stylesheet" href="css/estilos_combinados.css" />
  <script src="../js/calendario.js" defer></script>
</head>
<body  class="body-fondo">
    <?php include('encabezadoPROAalumno.php'); ?>

  <!-- ===== CONTENEDOR PRINCIPAL ===== -->
  <div class="calendario-container">

      <!-- ----------  Panel de próximos eventos  ---------- -->
      <aside class="panel-eventos">
          <h3 class="titulo-eventos">Próximos eventos</h3>

        <a href="#">

          <div class="tarjeta-evento">
              <span class="fecha-evento">25 may</span>
              <div class="info-evento">
                  <p class="nombre-evento">Tarea 1. Conjuntos y vectores</p>
                  <p class="asignatura-evento">Asignatura: Matemáticas</p>
              </div>
              <img src="../img/icono-tarea.jpg" class="icono-evento" alt="">
          </div>
        </a>
      <a href="#">
          <div class="tarjeta-evento">
              <span class="fecha-evento">27 may</span>
              <div class="info-evento">
                  <p class="nombre-evento">Tarea 2. Álgebra</p>
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
              <div class="day-name">Mon</div><div class="day-name">Tue</div>
              <div class="day-name">Wed</div><div class="day-name">Thu</div>
              <div class="day-name">Fri</div><div class="day-name">Sat</div>
              <div class="day-name">Sun</div>

              <div id="calendarDays" class="calendar-days"></div>
          </div>
      </div>

  </div>
  <!-- Script externo -->
</body>

</html>

