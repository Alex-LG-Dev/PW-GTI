<?php
include('encabezadoPROAalumno.php');
include('../bbdd/conexionbasesPROA.php');

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="../js/code.js" defer></script>
    <script src="../js/nombrecabezera.js" defer></script>
    <script src="../js/botonasignaturas.js" defer></script>
</head>

<body class="body-fondo">

<nav class="migas-de-pan">
    <p><a href="home-page-alumno.php">Inicio</a> &gt; <?= htmlspecialchars($asignatura) ?></p>
</nav>

<div class="contenedor">
    <h1 class="titulo-asignatura"><?= htmlspecialchars($asignatura) ?></h1>

    <div class="pestanas-encabezado">
        <a href="calendario_alumno.php"><button class="pestana">Calendario</button></a>
        <a href="Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $idAsignatura ?>"><button class="pestana">Tareas</button></a>
        <button class="pestana activa">Asignaturas</button>
    </div>

    <section class="home-section-asign doble-columna">
        <!-- Tareas próximas a entregar -->
        <section class="bloque-asignatura izquierda">
            <header class="texto-2">Tareas próximas a entregar</header>
            <ul class="tarjetas-asignaturas">
                <?php
                $query = "
                    SELECT t.ID_tarea, t.titulo, t.fecha_entrega, a.nombre AS nombre_asignatura
                    FROM tareas t
                    INNER JOIN asignaturas a ON t.ID_asignatura = a.ID_asignatura
                    INNER JOIN matriculas_alumnos ma ON ma.ID_asignatura = t.ID_asignatura
                    LEFT JOIN respuesta_tareas rt ON rt.ID_tarea = t.ID_tarea AND rt.ID_alumno = ?
                    WHERE 
                        ma.DNI = ?
                        AND t.publicada = 'Sí'
                        AND t.fecha_entrega > NOW()
                        AND rt.ID_tarea IS NULL
                        AND t.ID_asignatura = ?
                    ORDER BY t.fecha_entrega ASC
                    LIMIT 3
                ";
                $stmt = $conex->prepare($query);
                $stmt->bind_param("ssi", $dni, $dni, $idAsignatura);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows > 0):
                    while ($row = $res->fetch_assoc()):
                ?>
                        <li>
                            <a href="Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $row['ID_tarea'] ?>" class="linksAsign">
                                <article>
                                    <header class="titulo-tarea">
                                        <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                                        <img src="../img/icono-tarea.jpg" alt="">
                                    </header>
                                    <p class="linksAsignp">Asignatura: <?= htmlspecialchars($row['nombre_asignatura']) ?></p>
                                    <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
                                </article>
                            </a>
                        </li>
                    <?php endwhile; else: ?>
                    <li><p class="linksAsignp">No tienes tareas próximas por entregar</p></li>
                <?php endif; ?>
            </ul>
            <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $idAsignatura ?>'">Ver todas las Tareas</button>
        </section>

        <!-- Tareas calificadas -->
        <section class="bloque-asignatura derecha">
            <header class="texto-2">Tareas calificadas</header>
            <ul class="tarjetas-asignaturas">
                <?php
                $query = "
                    SELECT t.ID_tarea, t.titulo, t.fecha_entrega, a.nombre AS nombre_asignatura, rt.nota
                    FROM tareas t
                    INNER JOIN asignaturas a ON t.ID_asignatura = a.ID_asignatura
                    INNER JOIN respuesta_tareas rt ON rt.ID_tarea = t.ID_tarea
                    WHERE 
                        rt.ID_alumno = ?
                        AND rt.nota IS NOT NULL
                        AND t.ID_asignatura = ?
                    ORDER BY t.fecha_entrega ASC
                    LIMIT 3
                ";
                $stmt = $conex->prepare($query);
                $stmt->bind_param("si", $dni, $idAsignatura);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows > 0):
                    while ($row = $res->fetch_assoc()):
                ?>
                        <li>
                            <a href="Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $row['ID_tarea'] ?>" class="linksAsign">
                                <article>
                                    <header class="titulo-tarea">
                                        <h3><?= htmlspecialchars($row['titulo']) ?></h3>
                                        <img src="../img/icono-tarea.jpg" alt="">
                                    </header>
                                    <p class="linksAsignp">Asignatura: <?= htmlspecialchars($row['nombre_asignatura']) ?></p>
                                    <p class="linksAsignp">Fecha entrega: <?= date("d/m/Y H:i", strtotime($row['fecha_entrega'])) ?></p>
                                    <p class="linksAsignp">Nota: <?= htmlspecialchars($row['nota']) ?>/10</p>
                                </article>
                            </a>
                        </li>
                    <?php endwhile; else: ?>
                    <li><p class="linksAsignp">No tienes tareas calificadas aún 📘</p></li>
                <?php endif; ?>
            </ul>
            <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $idAsignatura ?>'">Ver todas las Tareas</button>
        </section>
    </section>
</div>
</body>
</html>
