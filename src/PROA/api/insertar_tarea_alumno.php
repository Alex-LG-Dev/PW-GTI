<?php
session_start();
include("conexion_bd_proa.php");

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: ../app/loginPROA.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['tarea_error'] = 'No se ha enviado el formulario.';
    header("Location: ../app/asignatura_seleccionada_tareas_alumno.php");
    exit;
}

$id_tarea = $_POST['id_tarea'] ?? null;
$texto_respuesta = $_POST['texto_respuesta'] ?? '';
$dni = $_SESSION['dni'];
$href = null;

if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
    $fileUpload = $_FILES['adjunto'];
    $target_dir = "../api/adjuntos/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $target_file = $target_dir . uniqid() . "_" . basename($fileUpload["name"]);
    $sizeLimit = 1024 * 1024 * 5;
    if ($fileUpload["size"] > $sizeLimit) {
        $_SESSION['tarea_error'] = 'El archivo adjunto es demasiado grande (max 5 MB)';
        header("Location: ../app/asignatura_seleccionada_tareas_alumno.php?id_asignatura=" . urlencode($_POST['id_asignatura'] ?? 1));
        exit;
    }
    if (!move_uploaded_file($fileUpload["tmp_name"], $target_file)) {
        $_SESSION['tarea_error'] = 'No se pudo guardar el archivo';
        header("Location: ../app/asignatura_seleccionada_tareas_alumno.php?id_asignatura=" . urlencode($_POST['id_asignatura'] ?? 1));
        exit;
    }
    $href = $target_file;
}

// Guarda la respuesta del alumno
$query = "INSERT INTO respuesta_tareas (ID_tarea, ID_alumno, texto_respuesta, fecha_de_entrega, href)
          VALUES (?, ?, ?, NOW(), ?)
          ON DUPLICATE KEY UPDATE texto_respuesta = VALUES(texto_respuesta), href = VALUES(href), fecha_de_entrega = NOW()";
$stmt = $conex->prepare($query);
$stmt->bind_param("isss", $id_tarea, $dni, $texto_respuesta, $href);

if ($stmt->execute()) {
    $_SESSION['tarea_enviada'] = true;
    header("Location: ../app/asignatura_seleccionada_tareas_alumno.php?id_asignatura=" . urlencode($_POST['id_asignatura']) . "&open=" . urlencode($_POST['id_tarea']));
    exit;
} else {
    $_SESSION['tarea_error'] = "Error al guardar la entrega: " . $stmt->error;
    header("Location: ../app/asignatura_seleccionada_tareas_alumno.php?id_asignatura=" . urlencode($_POST['id_asignatura'] ?? 1));
    exit;
}
?>
<?php
$id_asignatura = $_GET['ID_asignatura'] ?? 1;
?>
<a href="Crear_Tarea.php?ID_asignatura=<?= $id_asignatura ?>" class="botonPROA">Crear Tarea</a>