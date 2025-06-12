<?php

include('../api/conexion_bd_proa.php');
include('./encabezado_alumno.php');

$tareaEnviada = false;
if (isset($_SESSION['tarea_enviada'])) {
    $tareaEnviada = true;
    unset($_SESSION['tarea_enviada']);
}

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'alumno') {
  header("Location: loginPROA.php");
  exit();
}

$dni = $_SESSION['dni'];
$idAsignatura = $_GET['id_asignatura'] ?? $_GET['id'] ?? null;
$openTareaId = $_GET['open'] ?? null;

$pageCal = isset($_GET['page_cal']) ? max(1, (int)$_GET['page_cal']) : 1;
$pageNoCal = isset($_GET['page_nocal']) ? max(1, (int)$_GET['page_nocal']) : 1;
$limit = 4;

if (!$idAsignatura) {
  echo "<p>Asignatura no especificada.</p>";
  exit();
}

// === POST: enviar o actualizar respuesta ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tarea'], $_POST['texto_respuesta'])) {
  $idTarea = $_POST['id_tarea'];
  $texto = trim($_POST['texto_respuesta']);

  $check = $conex->prepare("SELECT COUNT(*) as existe FROM respuesta_tareas WHERE ID_tarea = ? AND ID_alumno = ?");
  $check->bind_param("is", $idTarea, $dni);
  $check->execute();
  $existe = $check->get_result()->fetch_assoc()['existe'];

  if ($existe) {
    $stmt = $conex->prepare("UPDATE respuesta_tareas SET texto_respuesta = ? WHERE ID_tarea = ? AND ID_alumno = ?");
    $stmt->bind_param("sis", $texto, $idTarea, $dni);
  } else {
    $stmt = $conex->prepare("INSERT INTO respuesta_tareas (ID_tarea, ID_alumno, texto_respuesta) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $idTarea, $dni, $texto);
  }

  $stmt->execute();
  header("Location: Asignatura_Seleccionada_tareas_Alumno.php?id_asignatura=$idAsignatura&open=$idTarea");
  exit();
}

// === Obtener nombre de asignatura ===
$stmt = $conex->prepare("SELECT nombre FROM asignaturas WHERE ID_asignatura = ?");
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$asignatura = $stmt->get_result()->fetch_assoc()['nombre'] ?? 'Asignatura';

// === Cargar tareas visibles para el alumno ===
$tareasCalificadas = [];
$tareasNoCalificadas = [];

$query = "
  SELECT ID_tarea, titulo, descripcion, fecha_entrega, fecha_publicacion
  FROM tareas
  WHERE ID_asignatura = ? AND publicada = 'Sí' AND fecha_publicacion <= NOW()
";
$stmt = $conex->prepare($query);
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$res = $stmt->get_result();

while ($tarea = $res->fetch_assoc()) {
  $idTarea = $tarea['ID_tarea'];

  $stmtResp = $conex->prepare("
    SELECT texto_respuesta, nota, href 
    FROM respuesta_tareas 
    WHERE ID_tarea = ? AND ID_alumno = ?
  ");
  $stmtResp->bind_param("is", $idTarea, $dni);
  $stmtResp->execute();
  $respuesta = $stmtResp->get_result()->fetch_assoc();

  $texto = $respuesta['texto_respuesta'] ?? '';
  $nota = $respuesta['nota'] ?? null;
  $href = $respuesta['href'] ?? null;

  $tarea['texto'] = $texto;
  $tarea['nota'] = $nota;
  $tarea['href'] = $href;

  $yaEntregada = (!empty($texto) || !empty($href));
  $fechaEntrega = $tarea['fecha_entrega'] ? strtotime($tarea['fecha_entrega']) : null;
  $fechaActual = time();
  $puedeEditar = !$yaEntregada && ($fechaEntrega === null || $fechaActual < $fechaEntrega);
  $isOpen = ($openTareaId == $idTarea);

  $tarea['puedeEditar'] = $puedeEditar;
  $tarea['isOpen'] = $isOpen;

  if (!is_null($nota)) {
    $tareasCalificadas[] = $tarea;
  } else {
    $tareasNoCalificadas[] = $tarea;
  }
}

// === Funciones ===
function paginarArray($array, $page, $limit)
{
  $offset = ($page - 1) * $limit;
  return array_slice($array, $offset, $limit);
}

function renderBloqueTareasAlumno($tareas, $titulo, $pageParam, $currentPage, $idAsignatura, $dni, $openTareaId, $limit)
{
  $total = count($tareas);
  $totalPages = ceil($total / $limit);
  $tareasPag = paginarArray($tareas, $currentPage, $limit);

  echo "<p class='linksAsignp'>$titulo</p>";
  if (empty($tareasPag)) {
    echo "<ul class='lista-tareas-asignatura'><li><p class='linksAsignp'>No hay tareas en esta categoría.</p></li></ul>";
    return;
  }

  echo "<ul class='lista-tareas-asignatura'>";
  foreach ($tareasPag as $tarea) {
    $idTarea = $tarea['ID_tarea'];
    $texto = $tarea['texto'];
    $nota = $tarea['nota'];
    $puedeEditar = $tarea['puedeEditar'];
    $isOpen = $tarea['isOpen'];
    $fechaEntrega = $tarea['fecha_entrega'] ? strtotime($tarea['fecha_entrega']) : null;
    $href = $tarea['href'] ?? null; // 
?>
    <li class="tarea tarea-estilo2 <?= $isOpen ? 'abierta' : '' ?>" data-id="<?= $idTarea ?>">
      <div class="contenedor-tarea-header clickable-header">
        <div class="tarea-header">
          <h2><?= htmlspecialchars($tarea['titulo']) ?></h2>
          <?php if ($fechaEntrega): ?>
            <span><?= date("d/m/Y H:i", $fechaEntrega) ?></span>
          <?php else: ?>
            <span class="sin-fecha">Sin fecha de entrega</span>
          <?php endif; ?>
          <?php if ($nota !== null): ?>
            <span class="nota-alumno"><?= $nota ?>/10</span>
          <?php endif; ?>
        </div>
        <div class="div-toggle">
          <img class="toggle" src="../img/<?= $isOpen ? 'flecha_arriba.png' : 'flecha_abajo.png' ?>" alt="Mostrar detalles">
        </div>
      </div>

      <div class="detalles-tarea <?= $isOpen ? '' : 'oculto' ?>">
        <p><strong>Descripción:</strong></p>
        <p><?= htmlspecialchars($tarea['descripcion']) ?></p>

        <form method="POST" enctype="multipart/form-data" class="form-respuesta" action="../api/insertar_tarea_alumno.php">
          <input type="hidden" name="id_tarea" value="<?= $idTarea ?>">
          <input type="hidden" name="id_asignatura" value="<?= $idAsignatura ?>">
          <label><strong>Tu respuesta:</strong></label>
          <textarea name="texto_respuesta" placeholder="Escribe tu respuesta..." <?= $puedeEditar ? '' : 'readonly' ?> ><?= htmlspecialchars($texto) ?></textarea>
          <input type="file" name="adjunto" <?= $puedeEditar ? '' : 'disabled' ?>>
          <?php if ($puedeEditar): ?>
            <button type="submit" class="btn-asignar">Enviar</button>
          <?php else: ?>
            <p class="aviso">Entrega cerrada o ya enviada</p>
            <?php if ($href): ?>
              <p>Archivo entregado: <a href="<?= htmlspecialchars($href) ?>" target="_blank">Descargar</a></p>
            <?php endif; ?>
          <?php endif; ?>
        </form>
      </div>
    </li>
<?php
  }
  echo "</ul>";

  if ($totalPages > 1) {
    echo "<div class='paginacion'>";
    for ($i = 1; $i <= $totalPages; $i++) {
      $clase = ($i == $currentPage) ? 'activa' : '';
      echo "<a class=\"$clase\" href=\"?id_asignatura=$idAsignatura&{$pageParam}=$i\">$i</a>";
    }
    echo "</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Tareas <?= htmlspecialchars($asignatura) ?> | PROA</title>
  <link rel="stylesheet" href="css/estilos_combinados.css">
  <script src="../js/code.js" defer></script>
  <script src="../js/tareas.js" defer></script>
</head>

<body class="body-fondo">
<?php if ($tareaEnviada): ?>
  <div class="alerta-tarea-exito" id="alerta-tarea">¡Tarea enviada con éxito!</div>
  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alerta-tarea');
      if (alerta) alerta.remove();
    }, 3000);
  </script>
<?php endif; ?>

  <nav class="migas_de_pan">
    <a href="./home_page_alumno.php">Inicio</a> &gt;
    <a href="./asignatura_seleccionada_alumno.php?id=<?= $idAsignatura ?>"><?= htmlspecialchars($asignatura) ?></a> &gt; Tareas
  </nav>

  <div class="encabezado-tareas">
    <h1>Tareas <?= htmlspecialchars($asignatura) ?></h1>
    <label class="caja-busqueda">
      <span class="icono-busqueda"></span>
      <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
    </label>
  </div>

  <div class="contenedor-tareas-grid">
    <div class="columna-tarea">
      <?php renderBloqueTareasAlumno($tareasCalificadas, 'Tareas Calificadas', 'page_cal', $pageCal, $idAsignatura, $dni, $openTareaId, $limit); ?>
    </div>
    <div class="columna-tarea">
      <?php renderBloqueTareasAlumno($tareasNoCalificadas, 'Tareas No Calificadas', 'page_nocal', $pageNoCal, $idAsignatura, $dni, $openTareaId, $limit); ?>
    </div>
  </div>

</body>

</html>