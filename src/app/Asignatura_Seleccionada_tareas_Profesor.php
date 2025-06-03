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
    <?php
    $id_asignatura = $_GET['id'] ?? 1;
    ?>
    <a href="Crear_Tarea.php?ID_asignatura=<?= urlencode($id_asignatura) ?>" class="botonPROA">Crear Tarea</a>
    <label class="caja-busqueda">
      <span ><img src="/img/lupa.png" alt="" class="icono-busqueda"></span>
      <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
    </label>
  </div>

  <!-- Lista tareas -->
  <ul class="lista-tareas-asignatura">
    <?php
    $query = "
  SELECT t.ID_tarea, t.titulo, t.descripcion, t.fecha_entrega, t.publicada
  FROM tareas t
  WHERE t.ID_asignatura = ?
  ORDER BY t.fecha_entrega ASC
  LIMIT ? OFFSET ?
";
    $stmt = $conex->prepare($query);
    $stmt->bind_param("iii", $idAsignatura, $limit, $offset);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0):
      while ($row = $res->fetch_assoc()):
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
      <?php endwhile;
    else: ?>
      <li>
        <p class="linksAsignp">No hay tareas creadas aún para esta asignatura</p>
      </li>
    <?php endif; ?>
  </ul>

  <!-- Paginación -->
  <div class="paginacion">
    <?php
    $stmt = $conex->prepare("SELECT COUNT(*) as total FROM tareas WHERE ID_asignatura = ?");
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