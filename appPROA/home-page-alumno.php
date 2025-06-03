<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <meta name="description" content="Pagina de Inicio Alumno PROA">
  <link rel="stylesheet" href="css/estilos_combinados.css">
  <script src="../js/botonasignaturas.js" defer></script>
  <script src="../js/nombrecabezera.js" defer></script>
  <title>Panel Alumno PROA</title>
</head>
<body class="body-fondo">

<?php
include('encabezadoPROAalumno.php');
include("../bbdd/conexionbasesPROA.php");
$dni = $_SESSION['dni'] ?? null;
?>

<main>
  <!-- LOGO + Intro -->
  <section class="home-section-logo">
    <img src="../img/Logo-Proa.png" alt="imagen1">
    <p class="p-azul">Tu espacio de estudio digital que acerca a profesores y alumnos.
      Nuestra plataforma digital transforma la enseñanza tradicional en una experiencia interactiva,
      flexible y accesible desde cualquier lugar.
    </p>
  </section>

  <!-- Asignaturas + Tareas -->
  <section class="home-section-asign">

    <!-- Últimas asignaturas -->
   <!-- Últimas asignaturas -->
<section class="bloque-asignatura" id="asignaturas">
  <header class="texto-2">Últimas asignaturas visitadas</header>
  <ul class="tarjetas-asignaturas">
  <?php
  include("../bbdd/conexionbasesPROA.php");
  $dni = $_SESSION['dni'] ?? null;

  if ($dni) {
    $query = "
      SELECT 
          a.ID_asignatura,
          a.nombre AS nombre_asignatura,
          ur.nombre AS nombre_profesor,
          (
              SELECT COUNT(*) FROM tareas t 
              WHERE 
                  t.ID_asignatura = a.ID_asignatura 
                  AND t.publicada = 'Sí' 
                  AND t.fecha_entrega > NOW()
                  AND t.ID_tarea NOT IN (
                      SELECT ID_tarea FROM respuesta_tareas WHERE ID_alumno = ?
                  )
          ) AS tareas_pendientes
      FROM asignaturas a
      INNER JOIN matriculas_alumnos ma ON ma.ID_asignatura = a.ID_asignatura
      LEFT JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
      LEFT JOIN usuarios_registrados ur ON ur.dni = mp.DNI
      WHERE ma.DNI = ?
      GROUP BY a.ID_asignatura
      ORDER BY a.ID_asignatura DESC
      LIMIT 3
    ";
    $stmt = $conex->prepare($query);
    $stmt->bind_param("ss", $dni, $dni);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0):
      while ($row = $res->fetch_assoc()): ?>
        <li>
          <a href="Asignatura_Seleccionada_Alumno.php?id=<?= $row['ID_asignatura'] ?>" class="linksAsign">
            <article>
              <header class="titulo-tarea">
                <h3><?= htmlspecialchars($row['nombre_asignatura']) ?></h3>
                <img src="../img/icono-asignatura.jpg" alt="">
              </header>
              <p class="linksAsignp">Profesor asignatura: <?= htmlspecialchars($row['nombre_profesor'] ?? 'Desconocido') ?></p>
              <p class="linksAsignp">Tareas pendientes: <?= $row['tareas_pendientes'] ?></p>
            </article>
          </a>
        </li>
      <?php endwhile;
    else: ?>
      <li><p class="linksAsignp">No estás matriculado en asignaturas aún</p></li>
    <?php endif;
  } ?>
</ul>

  <button class="pestana activa" onclick="toggleMenuAsignaturas()">Ver todas las Asignaturas</button>
</section>


    <!-- Tareas próximas -->
    <section class="bloque-asignatura" id="asignaturas">
      <h2 class="texto-2">Tareas próximas a entregar</h2>
      <ul class="tarjetas-asignaturas">
        <?php
        $idAsignaturaPrimera = null;

        if ($dni) {
          $query = "
            SELECT 
              t.ID_tarea,
              t.titulo,
              t.fecha_entrega,
              t.ID_asignatura,
              a.nombre AS nombre_asignatura
            FROM tareas t
            INNER JOIN asignaturas a ON t.ID_asignatura = a.ID_asignatura
            INNER JOIN matriculas_alumnos ma ON ma.ID_asignatura = t.ID_asignatura
            WHERE 
              ma.DNI = ?
              AND t.publicada = 'Sí'
              AND t.fecha_entrega > NOW()
              AND t.ID_tarea NOT IN (
                  SELECT ID_tarea FROM respuesta_tareas WHERE ID_alumno = ?
              )
            ORDER BY t.fecha_entrega ASC
            LIMIT 3
          ";
          $stmt = $conex->prepare($query);
          $stmt->bind_param("ss", $dni, $dni);
          $stmt->execute();
          $resTareas = $stmt->get_result();

          if ($resTareas->num_rows > 0):
            while ($row = $resTareas->fetch_assoc()):
              if (!$idAsignaturaPrimera) {
                $idAsignaturaPrimera = $row['ID_asignatura'];
              }
        ?>
              <li>
                <a href="Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $row['ID_asignatura'] ?>&open=<?= $row['ID_tarea'] ?>" class="linksAsign">
                  <article>
                    <header class="titulo-tarea">
                      <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                      <img src="../img/icono-tarea.jpg" alt="">
                    </header>
                    <p class="linksAsignp">Asignatura: <?= htmlspecialchars($row['nombre_asignatura']) ?></p>
                    <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
                  </article>
                </a>
              </li>
        <?php endwhile; else: ?>
            <li><p class="linksAsignp">No tienes tareas próximas por entregar</p></li>
        <?php endif; } ?>
      </ul>

      <?php if ($idAsignaturaPrimera): ?>
        <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $idAsignaturaPrimera ?>'">Ver todas las Tareas</button>
      <?php else: ?>
        <button class="pestana activa" disabled>No hay tareas disponibles</button>
      <?php endif; ?>
    </section>
  </section>
</main>

</body>
</html>
