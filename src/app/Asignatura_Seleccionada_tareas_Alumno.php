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
  <nav class="migas-de-pan">
    <a href="home-page-alumno.php">Inicio</a> &gt;
    <a href="Asignatura_Seleccionada_Alumno.php?id=<?= $idAsignatura ?>"><?= htmlspecialchars($asignatura) ?></a> &gt;
    Tareas
  </nav>

  <!-- Título -->
  <div class="encabezado-tareas">
    <h1>Tareas <?= htmlspecialchars($asignatura) ?></h1>
    <label class="caja-busqueda">
      <span class="icono-busqueda"></span>
      <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
    </label>
  </div>

  <!-- Lista de tareas -->
  <ul class="lista-tareas-asignatura">
    <?php
    $query = "
      SELECT 
        t.ID_tarea, 
        t.titulo, 
        t.descripcion, 
        t.fecha_entrega
      FROM tareas t
      WHERE 
        t.ID_asignatura = ?
        AND t.publicada = 'Sí'
      ORDER BY t.fecha_entrega ASC
    ";

    $stmt = $conex->prepare($query);
    $stmt->bind_param("i", $idAsignatura);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0):
      while ($row = $res->fetch_assoc()):
    ?>
        <li class="tarea">
          <div class="contenedor-tarea-header">
            <div class="tarea-header">
              <h2><?= htmlspecialchars($row['titulo']) ?></h2>
              <span><?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></span>
            </div>
            <div class="div-toggle">
              <img class="toggle" src="../img/flecha-abajo.png" alt="Mostrar detalles">
            </div>
          </div>
          <div class="detalles-tarea oculto">
            <p class="p-descripcion"><strong>Descripción:</strong></p>
            <p><?= htmlspecialchars($row['descripcion']) ?></p>
          </div>
        </li>
    <?php
      endwhile;
    else:
      echo '<li><p class="linksAsignp">No hay tareas publicadas aún para esta asignatura 📘</p></li>';
    endif;
    ?>
  </ul>

</body>

</html>
