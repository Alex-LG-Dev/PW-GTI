<?php
include('encabezado_profesor.php');
include_once('../api/conexion_bd_proa.php');

// Verificar sesión y rol
if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
  header("Location: loginPROA.php");
  exit();
}

// Obtener ID de asignatura desde GET
$idAsignatura = $_GET['id'] ?? $_GET['id_asignatura'] ?? null;
if (!$idAsignatura || !is_numeric($idAsignatura)) {
  echo "<p>Error: asignatura no especificada.</p>";
  exit();
}

// Consultar tareas para JS
$tareasJS = [];
$query = "
  SELECT t.ID_tarea, t.titulo, t.fecha_entrega, a.nombre AS materia
  FROM tareas t
  JOIN asignaturas a ON a.ID_asignatura = t.ID_asignatura
  WHERE t.fecha_entrega IS NOT NULL AND t.ID_asignatura = ?
";
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

$stmt = $conex->prepare("SELECT nombre FROM asignaturas WHERE ID_asignatura = ?");
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$result = $stmt->get_result();
$asignatura = $result->fetch_assoc()['nombre'] ?? 'Asignatura';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calendario Profesor</title>
  <link rel="stylesheet" href="./css/estilos_combinados.css" />
  <script src="../js/calendario.js" defer></script>
</head>

<body class="body-fondo"
      data-tareas='<?= json_encode($tareasJS, JSON_UNESCAPED_UNICODE) ?>'
      data-asignatura-id="<?= (int)$idAsignatura ?>"
      data-tarea-open="<?= isset($_GET['open']) ? (int)$_GET['open'] : '' ?>">
  <!-- Migas de pan -->
  <nav class="migas_de_pan">
  <a href="./home_page_profesor.php">Inicio</a> >
  <a href="./asignatura_seleccionada_profesor.php?id=<?= $idAsignatura ?>"><?= htmlspecialchars($asignatura) ?></a>
</nav>

  <div class="calendario-container">
    <!-- Panel de próximos eventos -->
    <aside class="panel-eventos">
      <h3 class="titulo-eventos">Próximos eventos</h3>
      <?php
      $hoy = date('Y-m-d H:i:s');
      $query = "
        SELECT t.ID_tarea, t.titulo, t.ID_asignatura, a.nombre AS asignatura, t.fecha_entrega 
        FROM tareas t
        JOIN asignaturas a ON a.ID_asignatura = t.ID_asignatura
        WHERE t.fecha_entrega IS NOT NULL 
          AND t.fecha_entrega >= ? 
          AND t.ID_asignatura = ?
        ORDER BY t.fecha_entrega ASC 
        LIMIT 5
      ";

      $stmt = $conex->prepare($query);
      $stmt->bind_param("si", $hoy, $idAsignatura);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()):
        $fecha = date('d M', strtotime($row['fecha_entrega']));
      ?>
        <a href="Asignatura_Seleccionada_tareas_Profesor.php?id=<?= $row['ID_asignatura'] ?>&open=<?= $row['ID_tarea'] ?>">
          <div class="tarjeta-evento">
            <span class="fecha-evento"><?= $fecha ?></span>
            <div class="info-evento">
              <p class="nombre-evento"><?= htmlspecialchars($row['titulo']) ?></p>
              <p class="asignatura-evento">Asignatura: <?= htmlspecialchars($row['asignatura']) ?></p>
            </div>
            <img src="../img/icono_tarea.jpg" class="icono-evento" alt="Tarea">
          </div>
        </a>
      <?php endwhile; ?>
    </aside>

    <!-- Calendario principal -->
    <div class="calendar">
      <div class="calendar-header">
        <button id="prevMonth">&#10094;</button>
        <h2 id="monthYear"></h2>
        <button id="nextMonth">&#10095;</button>
      </div>

      <div class="calendar-grid">
        <div class="day-name">Lun</div>
        <div class="day-name">Mar</div>
        <div class="day-name">Mie</div>
        <div class="day-name">Jue</div>
        <div class="day-name">Vie</div>
        <div class="day-name">Sab</div>
        <div class="day-name">Dom</div>
        <div id="calendarDays" class="calendar-days"></div>
      </div>
    </div>
  </div>
</body>
</html>
