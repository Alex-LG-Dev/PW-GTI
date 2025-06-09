<?php
include('encabezado_alumno.php');
include_once('../api/conexion_bd_proa.php');

// Obtener ID de asignatura
$idAsignatura = $_GET['id_asignatura'] ?? $_GET['id'] ?? null;
if (!$idAsignatura) {
  echo "<p>Error: asignatura no especificada.</p>";
  exit();
}

// Obtener tareas de esa asignatura para JS
$tareasJS = [];
$query = "SELECT t.ID_tarea, t.titulo, t.fecha_entrega, a.nombre AS materia
          FROM tareas t
          JOIN asignaturas a ON a.ID_asignatura = t.ID_asignatura
          WHERE t.fecha_entrega IS NOT NULL AND t.ID_asignatura = ?";
$stmt = $conex->prepare($query);
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $tareasJS[] = [
    'id' => $row['ID_tarea'],
    'id_asignatura' => $idAsignatura,
    'date' => substr($row['fecha_entrega'], 0, 10),
    'titulo' => $row['titulo'],
    'materia' => $row['materia']
  ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendario Alumno</title>
  <link rel="stylesheet" href="css/estilos_souphiane.css" />
  <link rel="stylesheet" href="css/estilos_combinados.css" />
  <script>
    const tareas = <?php echo json_encode($tareasJS); ?>;
  </script>
  <script src="../js/calendario.js" defer></script>
</head>

<body class="body-fondo">
  <div class="calendario-container">

    <!-- Panel de próximos eventos -->
    <aside class="panel-eventos">
      <h3 class="titulo-eventos">Próximos eventos</h3>
      <?php
      $hoy = date('Y-m-d H:i:s');
      $query = "SELECT t.ID_tarea, t.titulo, t.ID_asignatura, a.nombre AS asignatura, t.fecha_entrega 
                FROM tareas t
                JOIN asignaturas a ON a.ID_asignatura = t.ID_asignatura
                WHERE t.fecha_entrega IS NOT NULL AND t.fecha_entrega >= ? AND t.ID_asignatura = ?
                ORDER BY t.fecha_entrega ASC 
                LIMIT 5";

      if (isset($conex)) {
        $stmt = $conex->prepare($query);
        $stmt->bind_param("si", $hoy, $idAsignatura);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()):
          $fecha = date('d M', strtotime($row['fecha_entrega']));
      ?>
          <a href="Asignatura_Seleccionada_tareas_Alumno.php?id_asignatura=<?php echo $row['ID_asignatura']; ?>&open=<?php echo $row['ID_tarea']; ?>">
            <div class="tarjeta-evento">
              <span class="fecha-evento"><?php echo $fecha; ?></span>
              <div class="info-evento">
                <p class="nombre-evento"><?php echo $row['titulo']; ?></p>
                <p class="asignatura-evento">Asignatura: <?php echo $row['asignatura']; ?></p>
              </div>
              <img src="../img/icono-tarea.jpg" class="icono-evento" alt="">
            </div>
          </a>
      <?php endwhile;
      } else {
        echo "<p>Error: conexión no encontrada.</p>";
      }
      ?>
    </aside>

    <!-- Calendario -->
    <div class="calendar">
      <div class="calendar-header">
        <button id="prevMonth">&#10094;</button>
        <h2 id="monthYear"></h2>
        <button id="nextMonth">&#10095;</button>
      </div>
      <div class="calendar-grid">
        <div class="day-name">Mon</div>
        <div class="day-name">Tue</div>
        <div class="day-name">Wed</div>
        <div class="day-name">Thu</div>
        <div class="day-name">Fri</div>
        <div class="day-name">Sat</div>
        <div class="day-name">Sun</div>
        <div id="calendarDays" class="calendar-days"></div>
      </div>
    </div>

  </div>
</body>
</html>
