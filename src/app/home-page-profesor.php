<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Profesor PROA</title>
    <meta name="description" content="Página de Inicio Profesor PROA">
    <link rel="stylesheet" href="css/estilos_combinados.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="../js/nombrecabezera.js" defer></script>
    <script src="../js/botonasignaturas.js" defer></script>
</head>

<body class="body-fondo">
    <!-- ===== Encabezado ===== -->
    <?php include('encabezadoPROAprofesor.php'); ?>

    <main>

        <!--imagenes home page-->
        <section class="home-section-logo">
            <img src="../img/Logo-Proa.png" alt="imagen1">
            <p class="p-azul">Tu espacio de estudio digital que acerca a profesores y alumnos.
                Nuestra plataforma digital transforma la enseñanza tradicional en una experiencia interactiva,
                flexible y accesible desde cualquier lugar.</p>
        </section>
        <!--Tarjetas Asignaturas-->
        <section class="home-section-asign">
            <section class="bloque-asignatura" id="asignaturas">
                <header class="texto-2">Ultimas asignaturas visitadas</header>
                <ul class="tarjetas-asignaturas">
                    <?php
                    include("../bbdd/conexionbasesPROA.php");
                    $dni = $_SESSION['dni'];

                    // Traer asignaturas únicas del profesor
                    $query = "
    SELECT DISTINCT a.ID_asignatura, a.nombre 
    FROM asignaturas a
    INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
    WHERE mp.DNI = ?
    LIMIT 3
";
                    $stmt = $conex->prepare($query);
                    $stmt->bind_param("s", $dni);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($asig = $res->fetch_assoc()):
                    ?>
                        <li>
                            <a href="Asignatura_Seleccionada_Profesor.php?id=<?= $asig['ID_asignatura'] ?>" class="linksAsign">
                                <article>
                                    <header class="titulo-tarea">
                                        <h3><?= htmlspecialchars($asig['nombre']) ?></h3>
                                        <img src="../img/icono-asignatura.jpg" alt="">
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

                <button class="pestana activa" onclick="toggleMenuAsignaturas()">Ver todas las Asignaturas</button>
            </section>

            <!-- Columna de tareas -->
            <section class="bloque-asignatura" id="asignaturas">
                <h2 class="texto-2">Tareas próximas a expirar</h2>

                <ul class="tarjetas-asignaturas">
                    <?php
                    include("../bbdd/conexionbasesPROA.php");
                    if (!isset($_SESSION)) session_start();
                    $dni = $_SESSION['dni'] ?? null;

                    if ($dni) {
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
                                    <a href="Asignatura_Seleccionada_Profesor.php?id=<?= $row['ID_asignatura'] ?>" class="linksAsign">
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
                            <?php
                            endwhile;
                        else:
                            ?>
                            <li>
                                <p class="linksAsignp">No hay tareas futuras por expirar 🧘</p>
                            </li>
                    <?php endif;
                    } ?>
                </ul>


                <button class="pestana activa" onclick="location.href='Asignatura_Seleccionada_tareas_Profesor.php'">Ver todas las Tareas</button>
            </section>
        </section>
    </main>

</html>