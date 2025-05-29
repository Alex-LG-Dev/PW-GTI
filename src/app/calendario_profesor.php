<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calendario Profesor</title>
  <link rel="stylesheet" href="css/estilos_souphiane.css" />
  <link rel="stylesheet" href="css/estilos_combinados.css" />
  <script src="../js/calendario.js" defer></script>
  <script src="../js/nombrecabezera.js" defer></script>
</head>
<body>
    <?php include('encabezadoPROAprofesor.php'); ?>

    <!-- ============================  MIGAS DE PAN  ============================= -->
    <nav class="migas-de-pan">
      <p><a href="home-page-profesor.php">Inicio</a> &gt; Asignatura &gt; Tareas</p>
  <!-- ===== CONTENEDOR PRINCIPAL ===== -->
  <div class="calendario-container">

      <!-- ----------  Panel de próximos eventos  ---------- -->
      <aside class="panel-eventos">
          <h3 class="titulo-eventos">Próximos eventos</h3>

        <a href="../app/Asignatura_Seleccionada_Tareas_Profesor.php">

          <div class="tarjeta-evento">
              <span class="fecha-evento">25 may</span>
              <div class="info-evento">
                  <p class="nombre-evento">Tarea 1. Conjuntos y vectores</p>
                  <p class="asignatura-evento">Asignatura: Matemáticas</p>
              </div>
              <img src="../img/icono-tarea.jpg" class="icono-evento" alt="">
          </div>
        </a>
      <a href="../app/Asignatura_Seleccionada_Tareas_Profesor.php">
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

<!-- Modal para crear tarea -->
<div id="modalCrearTarea" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="cerrarModal" class="close" style="float:right;cursor:pointer;">&times;</span>
    <div class="titulo-asignatura">
      <h2>Crear Tarea Matemáticas</h2>
    </div>
    <form class="form-crear-tarea" id="formCrearTarea" method="POST" action="../bbdd/insertar_Tarea.php" enctype="multipart/form-data">
      <div class="form-interior">
        <label for="titulo">Título de la tarea</label>
        <input name="titulo" type="text" id="titulo" placeholder="Inserte aquí el titulo" required />
      </div>
      <div class="form-div-fecha">
        <div class="form-interior">
          <label for="modalFecha">Fecha entrega</label>
          <input name="fecha" type="date" id="modalFecha" required />
        </div>
        <div class="form-interior">
          <label for="hora">Hora</label>
          <input name="hora" type="time" id="hora" />
        </div>
        <input type="file" name="adjunto" id="adjunto">
        <input type="hidden" name="publicada" id="publicada" value="No" />
        <input type="hidden" name="ID_asignatura" value="1" />
      </div>
      <div class="form-interior">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="6"></textarea>
      </div>
      <div class="boton-guardar-form">
        <input type="submit" class="guardar" value="Guardar"></input>
      </div>
    </form>
  </div>
</div>

</body>

</html>

