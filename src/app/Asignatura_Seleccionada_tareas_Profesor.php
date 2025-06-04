<?php
include('encabezadoPROAprofesor.php');
include('../bbdd/conexionbasesPROA.php');

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
  header("Location: loginPROA.php");
  exit();
}

$dni = $_SESSION['dni'];
$idAsignatura = $_GET['id'] ?? null;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 4;
$offset = ($page - 1) * $limit;

if (!$idAsignatura) {
  echo "<p>Asignatura no especificada.</p>";
  exit();
}

// Obtener nombre de asignatura
$stmt = $conex->prepare("SELECT nombre FROM asignaturas WHERE ID_asignatura = ?");
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$res = $stmt->get_result();
$asignatura = $res->fetch_assoc()['nombre'] ?? 'Asignatura';
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

  <!-- Migas de pan -->
  <nav class="migas_de_pan">
    <a href="home-page-profesor.php">Inicio</a> &gt;
    <a href="Asignatura_Seleccionada_Profesor.php?id=<?= $idAsignatura ?>"><?= htmlspecialchars($asignatura) ?></a> &gt;
  </nav>

  <!-- Encabezado -->
  <div class="encabezado-tareas">
    <h1>Tareas <?= htmlspecialchars($asignatura) ?></h1>
    <?php $id_asignatura = $_GET['id'] ?? 1; ?>
    <label class="caja-busqueda">
      <span><img src="/img/lupa.png" alt="" class="icono-busqueda"></span>
      <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
    </label>
  </div>

  <?php
  $pageCal = isset($_GET['page_calificadas']) ? max(1, (int)$_GET['page_calificadas']) : 1;
  $pageNoCal = isset($_GET['page_nocalificadas']) ? max(1, (int)$_GET['page_nocalificadas']) : 1;
  $pageSinFecha = isset($_GET['page_sinfecha']) ? max(1, (int)$_GET['page_sinfecha']) : 1;
  $limit = 4;

  $tareasCalificadas = [];
  $tareasNoCalificadas = [];
  $tareasSinFecha = [];

  $stmt = $conex->prepare("SELECT * FROM tareas WHERE ID_asignatura = ?");
  $stmt->bind_param("i", $idAsignatura);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($tarea = $res->fetch_assoc()) {
    $id = $tarea['ID_tarea'];

    if (
      $tarea['publicada'] === 'Sí' &&
      empty($tarea['fecha_entrega'])
    ) {
      $tareasSinFecha[] = $tarea;
      continue;
    }



    // tareas publicadas => clasificamos según nota/respuesta
    $stmtResp = $conex->prepare("SELECT nota FROM respuesta_tareas WHERE ID_tarea = ?");
    $stmtResp->bind_param("i", $id);
    $stmtResp->execute();
    $resp = $stmtResp->get_result();

    $tieneRespuesta = false;
    $tieneNota = false;
    while ($r = $resp->fetch_assoc()) {
      $tieneRespuesta = true;
      if (!is_null($r['nota'])) {
        $tieneNota = true;
        break;
      }
    }

    if ($tieneNota) {
      $tareasCalificadas[] = $tarea;
    } else {
      $tareasNoCalificadas[] = $tarea;
    }
  }



  function paginarArray($array, $page, $limit)
  {
    $offset = ($page - 1) * $limit;
    return array_slice($array, $offset, $limit);
  }

  function renderBloqueTareas($tareas, $titulo, $paramPage, $currentPage, $idAsignatura, $limit)
  {
    $total = count($tareas);
    $totalPages = ceil($total / $limit);
    $tareasPagina = paginarArray($tareas, $currentPage, $limit);

    echo "<p class='linksAsignp'>$titulo</p>";
    if (empty($tareasPagina)) {
      echo "<ul class='lista-tareas-asignatura'><li><p class='linksAsignp'>No hay tareas en esta categoría.</p></li></ul>";
      return;
    }

    echo "<ul class='lista-tareas-asignatura'>";
    foreach ($tareasPagina as $row) {
  ?>
      <li class="tarea">
        <div class="contenedor-tarea-header">
          <div class="tarea-header">
            <h2><?= htmlspecialchars($row['titulo']) ?></h2>
            <span>
              <?= $row['fecha_entrega'] ? date("d/m/Y H:i", strtotime($row['fecha_entrega'])) : 'Aún sin fecha de entrega' ?>
            </span>
          </div>
          <div class="div-toggle">
            <img class="toggle" src="../img/flecha-abajo.png" alt="toggle">
          </div>
        </div>
        <div class="detalles-tarea oculto">
          <p class="p-descripcion"><strong>Descripción:</strong></p>
          <p><?= htmlspecialchars($row['descripcion']) ?></p>
          <form class="responder-tarea responder-tarea-profesor">
            <a href="poner_NOTA.php?id=<?= $row['ID_tarea'] ?>"><img src="../img/check.png" alt="">Calificar</a>
            <a href="Editar_Tarea.php?id=<?= $row['ID_tarea'] ?>"><img src="../img/lapizeditar.png" alt="">Editar</a>
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
        echo "<a class=\"$clase\" href=\"?id=$idAsignatura&{$paramPage}=$i\">$i</a>";
      }
      echo "</div>";
    }
  }
  ?>

  <!-- Mostrar tareas en 3 columnas -->
  <div class="contenedor-tareas-grid">
    <div class="columna-tarea">
      <?php renderBloqueTareas($tareasCalificadas, 'Tareas Calificadas', 'page_calificadas', $pageCal, $idAsignatura, $limit); ?>
    </div>
    <div class="columna-tarea">
      <?php renderBloqueTareas($tareasNoCalificadas, 'Tareas No Calificadas', 'page_nocalificadas', $pageNoCal, $idAsignatura, $limit); ?>
    </div>
    <div class="columna-tarea">
      <?php renderBloqueTareas($tareasSinFecha, 'Tareas Sin Fecha de Publicación', 'page_sinfecha', $pageSinFecha, $idAsignatura, $limit); ?>
    </div>
  </div>
<a href="Crear_Tarea.php?ID_asignatura=<?= urlencode($id_asignatura) ?>" class="botonPROA">Crear Tarea</a>
</body>

</html>