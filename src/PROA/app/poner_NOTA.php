<?php
include('../api/conexion_bd_proa.php');
include('./encabezado_profesor.php');

$tareaId = $_GET['id'] ?? null;
if (!$tareaId) {
    echo "<p>Error: Tarea no especificada.</p>";
    exit;
}

// Actualizar nota si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nota'], $_POST['id_alumno'])) {
    $nota = floatval($_POST['nota']);
    $idAlumno = $_POST['id_alumno'];
    $stmt = $conex->prepare("UPDATE respuesta_tareas SET nota = ? WHERE ID_tarea = ? AND ID_alumno = ?");
    $stmt->bind_param("dis", $nota, $tareaId, $idAlumno);
    $stmt->execute();
    exit;
}

// Obtener el ID de la asignatura de la tarea
$stmt = $conex->prepare("SELECT titulo, ID_asignatura FROM tareas WHERE ID_tarea = ?");
$stmt->bind_param("i", $tareaId);
$stmt->execute();
$tareaData = $stmt->get_result()->fetch_assoc();
$titulo = $tareaData['titulo'] ?? 'Sin título';
$idAsignatura = $tareaData['ID_asignatura'] ?? null;

// Obtener nombre de la asignatura
$asignatura = null;
if ($idAsignatura) {
    $stmt = $conex->prepare("SELECT nombre FROM asignaturas WHERE ID_asignatura = ?");
    $stmt->bind_param("i", $idAsignatura);
    $stmt->execute();
    $asignatura = $stmt->get_result()->fetch_assoc()['nombre'] ?? null;
}

// Obtener respuestas de alumnos
$stmt = $conex->prepare("
    SELECT ur.nombre, rt.ID_alumno, rt.texto_respuesta, rt.nota, rt.href
    FROM respuesta_tareas rt
    JOIN usuarios_registrados ur ON rt.ID_alumno = ur.dni
    WHERE rt.ID_tarea = ?
");
$stmt->bind_param("i", $tareaId);
$stmt->execute();
$respuestas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proa | Calificar tarea</title>
    <link rel="stylesheet" href="./css/estilos_combinados.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        async function asignarNota(btn) {
            const wrapper = btn.closest('.nota-wrapper');
            const input = wrapper.querySelector('input');
            const id_alumno = input.dataset.alumno;
            const nota = input.value;

            const formData = new FormData();
            formData.append('nota', nota);
            formData.append('id_alumno', id_alumno);

            const res = await fetch('', {
                method: 'POST',
                body: formData
            });

            if (res.ok) {
                btn.textContent = 'Guardado';
                setTimeout(() => btn.textContent = 'Asignar nota', 1500);
            }
        }
    </script>
</head>
<body class="body-fondo">
<main>
    <nav class="migas_de_pan">
        <a href="./home_page_profesor.php">Inicio</a> &gt;
        <a href="./asignatura_seleccionada_profesor.php?id=<?= urlencode($idAsignatura) ?>">
            <?= htmlspecialchars($asignatura ?? 'Asignatura') ?>
        </a> &gt;<a href="./asignatura_seleccionada_tareas_profesor.php?id=<?= urlencode($idAsignatura) ?>">
            <?= htmlspecialchars($tareaData['titulo'] ?? 'Asignatura') ?>
        </a> &gt;
        Calificar tarea
    </nav>

    <div class="contenedor">
        <h1><?= htmlspecialchars($titulo) ?></h1>

        <form id="form-notas" method="POST">
            <div class="cuadricula-calificacion">
                <?php
                $mitad = ceil(count($respuestas) / 2);
                $columnas = [array_slice($respuestas, 0, $mitad), array_slice($respuestas, $mitad)];
                foreach ($columnas as $columna):
                ?>
                    <div class="columna-calificacion">
                        <?php foreach ($columna as $res): ?>
                            <div class="nombre-alumno"><?= htmlspecialchars($res['nombre']) ?></div>
                            <div class="contenedor-entrega">
                                <div class="caja-entrega">
                                    <p><?= nl2br(htmlspecialchars($res['texto_respuesta'])) ?></p>
                                    <?php if (!empty($res['href'])): ?>
                                        <div class="archivo-adjunto">
                                            <strong>Archivo adjunto:</strong>
                                            <a href="<?= htmlspecialchars($res['href']) ?>" target="_blank" class="enlace-archivo">
                                                <?= basename(htmlspecialchars($res['href'])) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="nota-wrapper">
                                    <input type="number" name="notas[<?= $res['ID_alumno'] ?>]" value="<?= htmlspecialchars($res['nota']) ?>" min="0" max="10" data-alumno="<?= $res['ID_alumno'] ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="acciones-calificacion">
                <button type="submit" class="btn-asignar">Asignar todas las notas</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>

<?php
// Procesar todas las notas si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notas'])) {
    foreach ($_POST['notas'] as $idAlumno => $nota) {
        $nota = floatval($nota);
        $stmt = $conex->prepare("UPDATE respuesta_tareas SET nota = ? WHERE ID_tarea = ? AND ID_alumno = ?");
        $stmt->bind_param("dis", $nota, $tareaId, $idAlumno);
        $stmt->execute();
    }
    // Redirigir a la página de tareas de la asignatura
    header("Location: Asignatura_Seleccionada_tareas_Profesor.php?id=" . urlencode($idAsignatura));
    exit;
}
?>

