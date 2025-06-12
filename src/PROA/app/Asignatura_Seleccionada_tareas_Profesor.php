<?php
include('encabezado_profesor.php'); // Aquí ya se hace session_start()

$tareaCreada = false;
if (isset($_SESSION['tarea_creada'])) {
    $tareaCreada = true;
    unset($_SESSION['tarea_creada']);
}

$tareaEditada = false;
if (isset($_SESSION['tarea_editada'])) {
    $tareaEditada = true;
    unset($_SESSION['tarea_editada']);
}

$tareaEliminada = false;
if (isset($_SESSION['tarea_eliminada'])) {
    $tareaEliminada = true;
    unset($_SESSION['tarea_eliminada']);
}

include('../api/conexion_bd_proa.php');

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
  header("Location: login_proa.php");
  exit();
}

$dni = $_SESSION['dni'];
$idAsignatura = $_GET['id'] ?? null;

if (!$idAsignatura) {
  echo "<p>Asignatura no especificada.</p>";
  exit();
}

$stmt = $conex->prepare("SELECT nombre FROM asignaturas WHERE ID_asignatura = ?");
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$res = $stmt->get_result();
$asignatura = $res->fetch_assoc()['nombre'] ?? 'Asignatura';

$tareas = [];
$stmt = $conex->prepare("SELECT * FROM tareas WHERE ID_asignatura = ?");
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$res = $stmt->get_result();

while ($tarea = $res->fetch_assoc()) {
  $idTarea = $tarea['ID_tarea'];
  $fechaEntrega = $tarea['fecha_entrega'];
  $tarea['estado'] = 'nocalificada'; // Default

  if (empty($fechaEntrega)) {
    $tarea['estado'] = 'sin_fecha';
  } else {
    $stmtNota = $conex->prepare("SELECT nota FROM respuesta_tareas WHERE ID_tarea = ?");
    $stmtNota->bind_param("i", $idTarea);
    $stmtNota->execute();
    $resNota = $stmtNota->get_result();
    while ($fila = $resNota->fetch_assoc()) {
      if (!is_null($fila['nota'])) {
        $tarea['estado'] = 'calificada';
        break;
      }
    }
  }

  $tareas[] = $tarea;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Tareas <?= htmlspecialchars($asignatura) ?> | PROA</title>
  <link rel="stylesheet" href="./css/estilos_combinados.css">
  <script src="../js/tareas.js" defer></script>
</head>

<body class="body-login body-fondo" data-tarea-open="<?= isset($_GET['open']) ? (int)$_GET['open'] : '' ?>">
<?php if ($tareaCreada): ?>
  <div class="alerta-tarea-exito" id="alerta-tarea">¡Tarea creada con éxito!</div>
  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alerta-tarea');
      if (alerta) alerta.remove();
    }, 3000);
  </script>
<?php endif; ?>
<?php if ($tareaEditada): ?>
  <div class="alerta-tarea-exito" id="alerta-tarea">¡Tarea editada con éxito!</div>
  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alerta-tarea');
      if (alerta) alerta.remove();
    }, 3000);
  </script>
<?php endif; ?>
<?php if ($tareaEliminada): ?>
  <div class="alerta-tarea-exito" id="alerta-tarea">¡Tarea eliminada con éxito!</div>
  <script>
    setTimeout(function() {
      var alerta = document.getElementById('alerta-tarea');
      if (alerta) alerta.remove();
    }, 3000);
  </script>
<?php endif; ?>
  <nav class="migas_de_pan">
    <a href="./home_page_profesor.php">Inicio</a> >
    <a href="./asignatura_seleccionada_profesor.php?id=<?= $idAsignatura ?>"><?= htmlspecialchars($asignatura) ?></a> >
    Tareas
  </nav>

  <div class="encabezado-tareas">
    <h1>Tareas <?= htmlspecialchars($asignatura) ?></h1>
  </div>
  <div class="bloque-but-crear">
    <div class="bloque-filtros">
      <div class="filtros-opciones">
        <label class="label-filtro">Filtrar Tareas:</label>
        <button class="filtro-btn" data-estado="calificada">Tareas Calificadas</button>
        <button class="filtro-btn" data-estado="nocalificada">Tareas No Calificadas</button>
        <button class="filtro-btn" data-estado="sin_fecha">Tareas Guardadas</button>
      </div>
      <div class="filtros-extra">
        <label for="filtro-fecha">Fecha:</label>
        <input type="date" id="filtro-fecha" class="filtro-fecha">

        <label for="filtro-nombre">Nombre:</label>
        <input type="search" id="filtro-nombre" placeholder="Buscar por nombre">
      </div>
    </div>
    <a href="crear_tarea.php?ID_asignatura=<?= urlencode($idAsignatura) ?>" class="botonPROA">Crear tarea<img src="../img/crear.png" alt=""></a>
  </div>

  <ul class="lista-tareas-asignatura">
    <?php foreach ($tareas as $tarea): ?>
      <li class="tarea"
        data-id="<?= $tarea['ID_tarea'] ?>"
        data-estado="<?= $tarea['estado'] ?>"
        data-nombre="<?= strtolower($tarea['titulo']) ?>"
        data-fecha="<?= $tarea['fecha_entrega'] ?>">
        <div class="contenedor-tarea-header clickable-header">
          <div class="tarea-header">
            <h2><?= htmlspecialchars($tarea['titulo']) ?></h2>
            <span><?= $tarea['fecha_entrega']
                    ? date("d/m/Y H:i", strtotime($tarea['fecha_entrega']))
                    : 'Aún sin fecha de entrega' ?></span>
          </div>
          <div class="div-toggle">
            <img class="toggle" src="../img/flecha_abajo.png" alt="toggle">
          </div>
        </div>
        <div class="detalles-tarea oculto">
          <p class="p-descripcion"><strong>Descripción:</strong></p>
          <p><?= htmlspecialchars($tarea['descripcion']) ?></p>

          <div class="responder-tarea responder-tarea-profesor">
            <a href="poner_nota.php?id=<?= $tarea['ID_tarea'] ?>"><img src="../img/check.png" alt="">Calificar</a>
            <a href="editar_tarea.php?id=<?= $tarea['ID_tarea'] ?>"><img src="../img/lapiz_editar.png" alt="">Editar</a>

            <form method="POST" action="eliminar_tarea.php" onsubmit="return confirm('¿Seguro que deseas eliminar esta tarea?');">
              <input type="hidden" name="id_tarea" value="<?= $tarea['ID_tarea'] ?>">
              <input type="hidden" name="id_asignatura" value="<?= $idAsignatura ?>">
              <button type="submit" class="btn-eliminar">
                <img src="../img/trash.png" alt="">Eliminar
              </button>
            </form>
          </div>
        </div>

      </li>
    <?php endforeach; ?>
  </ul>
</body>

</html>