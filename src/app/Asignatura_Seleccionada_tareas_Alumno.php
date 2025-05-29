<?php
include('../bbdd/conexionbasesPROA.php');
include('encabezadoPROAalumno.php');

// Validar sesión
if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'alumno') {
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
  <link rel="stylesheet" href="css/estilos_jose.css">
  <script src="../js/code.js" defer></script>
  <script src="../js/tareas.js" defer></script>
</head>

<body class="body-fondo">

  <!-- Migas de pan -->
  <nav class="migas_de_pan">
    <a href="home-page-alumno.php">Inicio</a> &gt;
    <a href="Asignatura_Seleccionada_Alumno.php?id=<?= $idAsignatura ?>"><?= htmlspecialchars($asignatura) ?></a> &gt;
    Tareas
  </nav>

<div class="encabezado-tareas">
  <h1>Tareas <?= htmlspecialchars($asignatura) ?></h1>
  <label class="caja-busqueda">
    <span ><img src="/img/lupa.png" alt="" class="icono-busqueda"></span>
    <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
  </label>
</div>

<ul class="lista-tareas-asignatura">
<?php
$query = "
  SELECT 
    t.ID_tarea, t.titulo, t.descripcion, t.fecha_entrega
  FROM tareas t
  WHERE t.ID_asignatura = ? AND t.publicada = 'Sí'
  ORDER BY t.fecha_entrega ASC
  LIMIT ? OFFSET ?
";
$stmt = $conex->prepare($query);
$stmt->bind_param("iii", $idAsignatura, $limit, $offset);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0):
  while ($tarea = $res->fetch_assoc()):
  $idTarea = $tarea['ID_tarea'];
  $fechaEntrega = strtotime($tarea['fecha_entrega']);
  $fechaActual = strtotime(date("Y-m-d H:i:s"));

  // Consulta de respuesta y nota si existe
  $stmtResp = $conex->prepare("
    SELECT texto_respuesta, nota 
    FROM respuesta_tareas 
    WHERE ID_tarea = ? AND ID_alumno = ?
  ");
  $stmtResp->bind_param("is", $idTarea, $dni);
  $stmtResp->execute();
  $respuesta = $stmtResp->get_result()->fetch_assoc();
  $texto = $respuesta['texto_respuesta'] ?? '';
  $nota = $respuesta['nota'] ?? null;

  $puedeEditar = empty($texto) && $fechaActual < $fechaEntrega;
?>
<li class="tarea tarea-estilo2">
  <div class="contenedor-tarea-header">
    <div class="tarea-header">
      <h2><?= htmlspecialchars($tarea['titulo']) ?></h2>
      <span><?= date("d/m/Y H:i", $fechaEntrega) ?></span>
      <?php if ($nota !== null): ?>
        <span class="nota-alumno"><?= $nota ?>/10</span>
      <?php endif; ?>
    </div>
    <div class="div-toggle">
      <img class="toggle" src="../img/flecha-abajo.png" alt="Mostrar detalles">
    </div>
  </div>

  <div class="detalles-tarea oculto">
    <p><strong>Descripción:</strong></p>
    <p><?= htmlspecialchars($tarea['descripcion']) ?></p>

    <form action="guardar_respuesta.php" method="POST" enctype="multipart/form-data" class="form-respuesta">
      <input type="hidden" name="id_tarea" value="<?= $idTarea ?>">

      <label for="respuesta"><strong>Tu respuesta:</strong></label>
      <textarea name="texto_respuesta" placeholder="Escribe tu respuesta aquí..." 
        <?= $puedeEditar ? '' : 'readonly' ?> required><?= htmlspecialchars($texto) ?></textarea>

      <label><strong>Subir archivo:</strong></label>
      <input type="file" name="archivo" <?= $puedeEditar ? '' : 'disabled' ?>>

      <?php if ($puedeEditar): ?>
        <button type="submit" class="btn-asignar">Enviar</button>
      <?php else: ?>
        <p class="aviso">Entrega cerrada o ya enviada</p>
      <?php endif; ?>
    </form>
  </div>
</li>
<?php
  endwhile;
else:
?>
  <li><p class="linksAsignp">No hay tareas publicadas aún</p></li>
<?php endif; ?>
</ul>

<div class="paginacion">
<?php
$stmt = $conex->prepare("SELECT COUNT(*) as total FROM tareas WHERE ID_asignatura = ? AND publicada = 'Sí'");
$stmt->bind_param("i", $idAsignatura);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
$totalPaginas = ceil($total / $limit);

for ($i = 1; $i <= $totalPaginas; $i++):
  $clase = ($i == $page) ? 'activa' : '';
?>
  <a class="<?= $clase ?>" href="?id=<?= $idAsignatura ?>&page=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>
</div>

</body>
</html>
