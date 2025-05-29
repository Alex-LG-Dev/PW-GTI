<?php
include('../bbdd/conexionbasesPROA.php');
include('encabezadoPROAprofesor.php');
session_start();

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

// Obtener título de la tarea
$stmt = $conex->prepare("SELECT titulo FROM tareas WHERE ID_tarea = ?");
$stmt->bind_param("i", $tareaId);
$stmt->execute();
$titulo = $stmt->get_result()->fetch_assoc()['titulo'] ?? 'Sin título';

// Obtener respuestas de alumnos
$stmt = $conex->prepare("
    SELECT ur.nombre, rt.ID_alumno, rt.texto_respuesta, rt.nota
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
    <link rel="stylesheet" href="css/estilos_combinados.css">
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
                btn.textContent = '✓ Guardado';
                setTimeout(() => btn.textContent = 'Asignar nota', 1500);
            }
        }
    </script>
</head>
<body class="body-fondo">
<main>
    <nav class="migas-de-pan">
        <a href="home-page-profesor.php">Inicio</a> &gt; Calificar tarea
    </nav>

    <div class="contenedor">
        <h1><?= htmlspecialchars($titulo) ?></h1>

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
                            </div>
                            <div class="nota-wrapper">
                                <input type="number" value="<?= htmlspecialchars($res['nota']) ?>" min="0" max="10" data-alumno="<?= $res['ID_alumno'] ?>">
                                <button class="btn-asignar" onclick="asignarNota(this)">Asignar nota</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
</body>
</html>
