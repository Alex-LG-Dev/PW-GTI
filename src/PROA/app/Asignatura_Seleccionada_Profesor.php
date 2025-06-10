<?php
include('./encabezado_profesor.php');
include('../api/conexion_bd_proa.php');

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
</head>

<body class="body-fondo">

  <!-- Migas de pan -->
  <nav class="migas_de_pan">
    <a href="./home_page_profesor.php">Inicio</a> &gt; <?= htmlspecialchars($asignatura) ?>
  </nav>

  <h1 class="asignatura-seleccionadaid"><?= htmlspecialchars($asignatura) ?></h1>

    <div class="pestanas-encabezado">
        <a href="./calendario_profesor.php?id_asignatura=<?= $idAsignatura ?>"><button class="pestana">Calendario</button></a>
        <a href="./asignatura_seleccionada_tareas_profesor.php?id=<?= $idAsignatura ?>"><button class="pestana">Tareas</button></a>
        <button class="pestana activa">Asignaturas</button>
    </div>

    <section class="home-section-asign">

        <!-- IZQUIERDA: Tareas próximas a entregar -->
        <section class="bloque-asignatura">
            <header class="texto-2">Tareas próximas a entregar</header>
             <ul class="tarjetas-asignaturas">
        <?php
        $query = "
            SELECT 
                t.ID_tarea, t.titulo, t.fecha_entrega, t.ID_asignatura, a.nombre AS nombre_asignatura
            FROM tareas t
            INNER JOIN asignaturas a ON t.ID_asignatura = a.ID_asignatura
            INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
            WHERE mp.DNI = ?
              AND t.publicada = 'Sí'
              AND t.fecha_entrega > NOW()
            ORDER BY t.fecha_entrega ASC
            LIMIT 3";

        $stmt = $conex->prepare($query);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0):
            while ($row = $res->fetch_assoc()):
        ?>
            <li>
                <a href="./editar_tarea.php?= $row['ID_tarea'] ?>" class="linksAsign">
                    <article>
                        <header class="titulo-tarea">
                            <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                            <img src="../img/icono_tarea.jpg" alt="">
                        </header>
                        <p class="linksAsignp">Asignatura: <?= htmlspecialchars($row['nombre_asignatura']) ?></p>
                        <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
                    </article>
                </a>
            </li>
        <?php endwhile; else: ?>
            <li><p class="linksAsignp">No hay tareas futuras por expirar</p></li>
        <?php endif; ?>
    </ul>
            <button class="pestana activa" onclick="location.href='./asignatura_seleccionada_tareas_profesor.php?id=<?= $idAsignatura ?>'">Ver todas las tareas</button>
        </section>

        <!-- DERECHA: Últimas tareas guardadas -->
        <section class="bloque-asignatura">
            <header class="texto-2">Últimas tareas guardadas</header>
            <ul class="tarjetas-asignaturas">
                <?php
                $query = "
            SELECT 
                t.ID_tarea, t.titulo, t.fecha_entrega, a.nombre AS nombre_asignatura
            FROM tareas t
            INNER JOIN asignaturas a ON t.ID_asignatura = a.ID_asignatura
            INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = t.ID_asignatura
            WHERE mp.DNI = ?
            ORDER BY t.fecha_publicacion DESC
            LIMIT 3";

                $stmt = $conex->prepare($query);
                $stmt->bind_param("s", $dni);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows > 0):
                    while ($row = $res->fetch_assoc()):
                ?>
                        <li>
                            <a href="./editar_tarea.php?= $row['ID_tarea'] ?>" class="linksAsign">
                                <article>
                                    <header class="titulo-tarea">
                                        <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                                        <img src="../img/icono_tarea.jpg" alt="">
                                    </header>
                                    <p class="linksAsignp">Asignatura: <?= htmlspecialchars($row['nombre_asignatura']) ?></p>
                                    <?php if (!empty($row['fecha_entrega']) && $row['fecha_entrega'] !== '0000-00-00 00:00:00'): ?>
                                        <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
                                    <?php else: ?>
                                        <p class="linksAsignp">Aún sin fecha de entrega</p>
                                    <?php endif; ?>
                                </article>
                            </a>
                        </li>
                <?php
                    endwhile;
                else:
                    echo '<li><p class="linksAsignp">No hay tareas recientes creadas</p></li>';
                endif;
                ?>
            </ul>
            <button class="pestana activa" onclick="location.href='./asignatura_seleccionada_tareas_profesor.php?id=<?= $idAsignatura ?>'">Ver todas las tareas</button>
        </section>

    </section>

</body>

</html>