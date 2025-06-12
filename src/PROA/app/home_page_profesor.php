<?php
include('./encabezado_profesor.php');
include("../api/conexion_bd_proa.php");

$dni = $_SESSION['dni'] ?? null;
$idAsignaturaPrimera = null;

// Obtener primera asignatura con tareas activas
if ($dni) {
    $stmt = $conex->prepare("
        SELECT a.ID_asignatura
        FROM asignaturas a
        INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
        INNER JOIN tareas t ON t.ID_asignatura = a.ID_asignatura
        WHERE mp.DNI = ? AND t.publicada = 'Sí' AND t.fecha_entrega > NOW()
        ORDER BY t.fecha_entrega ASC
        LIMIT 1
    ");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $resPrimera = $stmt->get_result();
    if ($fila = $resPrimera->fetch_assoc()) {
        $idAsignaturaPrimera = $fila['ID_asignatura'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Profesor PROA</title>
    <meta name="description" content="Página de Inicio Profesor PROA">
    <link rel="stylesheet" href="css/estilos_combinados.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="../js/code.js" defer></script>
</head>

<body class="body-fondo">

    <main>


        <!-- Asignaturas + Tareas -->
        <section class="home-section-asign">

            <!-- Últimas asignaturas -->
            <section class="bloque-asignatura" id="asignaturas">
                <header class="texto-2">Asignaturas con mas tareas guardadas</header>
                <ul class="tarjetas-asignaturas">
                    <?php
                    $query = "
                    SELECT 
        a.ID_asignatura, 
        a.nombre,
        (
            SELECT COUNT(*) 
            FROM tareas t 
            WHERE t.ID_asignatura = a.ID_asignatura AND t.publicada = 'Sí'
        ) AS total_tareas
    FROM asignaturas a
    INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
    WHERE mp.DNI = ?
    ORDER BY total_tareas DESC, a.nombre ASC
    LIMIT 3
                ";
                    $stmt = $conex->prepare($query);
                    $stmt->bind_param("s", $dni);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($asig = $res->fetch_assoc()):
                    ?>
                        <li>
                            <a href="./Asignatura_Seleccionada_Profesor.php?id=<?= $asig['ID_asignatura'] ?>" class="linksAsign">
                                <article>
                                    <header class="titulo-tarea">
                                        <h3><?= htmlspecialchars($asig['nombre']) ?></h3>
                                        <img src="../img/icono_asignatura.jpg" alt="">
                                    </header>
                                    <p class="linksAsignp">Profesor asignatura: <?= $_SESSION['nombre'] ?? 'Profesor' ?></p>
                                    <p class="linksAsignp">
                                        Tareas publicadas:
                                        <?php
                                        $count = $conex->prepare("SELECT COUNT(*) AS total FROM tareas WHERE ID_asignatura = ? AND publicada = 'Sí'");
                                        $count->bind_param("i", $asig['ID_asignatura']);
                                        $count->execute();
                                        $num = $count->get_result()->fetch_assoc();
                                        echo $num['total'];
                                        ?>
                                    </p>
                                </article>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <!-- Botón ver todas las asignaturas (abre el menú del header) -->
                <button class="pestana activa" onclick="location.href='asignaturas_profesor.php'">Ver todas las Asignaturas</button>
            </section>
            <!-- LOGO -->
            <section class="home-section-logo">
                <img src="../img/logo_proa.png" alt="imagen1">
                <p class="p-azul">Tu espacio de estudio digital que acerca a profesores y alumnos.
                    Nuestra plataforma digital transforma la enseñanza tradicional en una experiencia interactiva,
                    flexible y accesible desde cualquier lugar.</p>
            </section>

            <!-- Tareas próximas -->
            <section class="bloque-asignatura" id="tareas">
                <h2 class="texto-2">Tareas próximas a expirar</h2>
                <ul class="tarjetas-asignaturas">
                    <?php
                    $query = "
                    SELECT 
                        t.ID_tarea,
                        t.titulo,
                        t.fecha_entrega,
                        t.ID_asignatura,
                        a.nombre AS nombre_asignatura
                    FROM tareas t
                    INNER JOIN asignaturas a ON t.ID_asignatura = a.ID_asignatura
                    INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
                    WHERE 
                        mp.DNI = ?
                        AND t.publicada = 'Sí'
                        AND t.fecha_entrega > NOW()
                    ORDER BY t.fecha_entrega ASC
                    LIMIT 3
                ";
                    $stmt = $conex->prepare($query);
                    $stmt->bind_param("s", $dni);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($res->num_rows > 0):
                        while ($row = $res->fetch_assoc()):
                    ?>
                            <li>
                                <a href="./editar_tarea.php?id=<?= $row['ID_tarea'] ?>" class="linksAsign">
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
                        <?php endwhile;
                    else: ?>
                        <li>
                            <p class="linksAsignp">No hay tareas futuras por expirar</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </section>

        </section>
    </main>

</body>

</html>