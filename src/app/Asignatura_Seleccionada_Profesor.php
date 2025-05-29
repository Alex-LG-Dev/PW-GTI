<?php
include('encabezadoPROAprofesor.php');
include('../bbdd/conexionbasesPROA.php');

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
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
$asignatura = $stmt->get_result()->fetch_assoc()['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>PROA | <?= htmlspecialchars($asignatura) ?></title>
  <link rel="stylesheet" href="css/estilos_combinados.css">
  <script src="../js/code.js" defer></script>
  <script src="../js/nombrecabezera.js" defer></script>
  <script src="../js/botonasignaturas.js" defer></script>
</head>

<body class="body-fondo">

  <!-- Migas de pan -->
  <nav class="migas-de-pan">
    <a href="home-page-profesor.php">Inicio</a> &gt; <?= htmlspecialchars($asignatura) ?>
  </nav>

  <h1 class="titulo-asignatura"><?= htmlspecialchars($asignatura) ?></h1>

  <div class="pestanas-encabezado">
    <a href="calendario_profesor.php"><button class="pestana">Calendario</button></a>
    <a href="Asignatura_Seleccionada_tareas_Profesor.php?id=<?= $idAsignatura ?>"><button class="pestana">Tareas</button></a>
    <button class="pestana activa">Asignaturas</button>
  </div>

  <section class="home-section-asign">

    <!-- IZQUIERDA: Tareas próximas a entregar -->
    <section class="bloque-asignatura">
      <header class="texto-2">Tareas próximas a entregar</header>
      <ul class="tarjetas-asignaturas">
        <?php
        $query = "
          SELECT ID_tarea, titulo, fecha_entrega
          FROM tareas
          WHERE ID_asignatura = ?
            AND publicada = 'Sí'
            AND fecha_entrega > NOW()
          ORDER BY fecha_entrega ASC
          LIMIT 3
        ";
        $stmt = $conex->prepare($query);
        $stmt->bind_param("i", $idAsignatura);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0):
          while ($row = $res->fetch_assoc()):
        ?>
          <li>
            <a href="Asignatura_Seleccionada_tareas_Profesor.php?id=<?= $row['ID_tarea'] ?>" class="linksAsign">
              <article>
                <header class="titulo-tarea">
                  <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                  <img src="../img/icono-tarea.jpg" alt="">
                </header>
                <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
              </article>
            </a>
          </li>
        <?php endwhile; else: ?>
          <li><p class="linksAsignp">No hay tareas próximas a entregar</p></li>
        <?php endif; ?>
      </ul>
      <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Profesor.php?id=<?= $idAsignatura ?>'">Ver todas las tareas</button>
    </section>

    <!-- DERECHA: Últimas tareas guardadas -->
    <section class="bloque-asignatura">
      <header class="texto-2">Últimas tareas guardadas</header>
      <ul class="tarjetas-asignaturas">
        <?php
        $query = "
          SELECT ID_tarea, titulo, fecha_entrega
          FROM tareas
          WHERE ID_asignatura = ?
            AND publicada = 'Sí'
          ORDER BY ID_tarea DESC
          LIMIT 3
        ";
        $stmt = $conex->prepare($query);
        $stmt->bind_param("i", $idAsignatura);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0):
          while ($row = $res->fetch_assoc()):
        ?>
          <li>
            <a href="Asignatura_Seleccionada_tareas_Profesor.php?id=<?= $row['ID_tarea'] ?>" class="linksAsign">
              <article>
                <header class="titulo-tarea">
                  <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                  <img src="../img/icono-tarea.jpg" alt="">
                </header>
                <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
              </article>
            </a>
          </li>
        <?php endwhile; else: ?>
          <li><p class="linksAsignp">No hay tareas guardadas aún</p></li>
        <?php endif; ?>
      </ul>
      <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Profesor.php?id=<?= $idAsignatura ?>'">Ver todas las tareas</button>
    </section>

  </section>

</body>
</html>
