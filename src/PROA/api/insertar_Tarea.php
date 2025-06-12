<?php
session_start();
include("conexion_bd_proa.php");

const HOST_URL = 'http://localhost';

function procesarAdjunto() {
    global $conex;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['tarea_error'] = 'No se ha enviado el formulario.';
        $id_asignatura = $_GET['ID_asignatura'] ?? 1;
        header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
        exit;
    }

    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $id_asignatura = intval($_POST['ID_asignatura'] ?? ($_GET['ID_asignatura'] ?? 1));

    if ($titulo === '') {
        $_SESSION['tarea_error'] = 'Por favor completa el título de la tarea.';
        header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
        exit;
    }

    // Si hay fecha y hora, se publica, si no, no
    $fecha_entrega = (!empty($fecha) && !empty($hora)) ? "$fecha $hora:00" : null;
    $publicada = $fecha_entrega ? 'Sí' : 'No';

    $href = null;
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        $fileUpload = $_FILES['adjunto'];
        $target_dir = "../api/adjuntos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $nombreArchivo = basename($fileUpload["name"]);
        $target_file = $target_dir . $nombreArchivo;

        if (file_exists($target_file)) {
            $_SESSION['tarea_error'] = 'El archivo ya existe.';
            header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
            exit;
        }

        $sizeLimit = 1024 * 1024 * 5;
        if ($fileUpload["size"] > $sizeLimit) {
            $_SESSION['tarea_error'] = 'El archivo adjunto es demasiado grande (máx 5 MB).';
            header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
            exit;
        }

        if (!move_uploaded_file($fileUpload["tmp_name"], $target_file)) {
            $_SESSION['tarea_error'] = 'No se pudo guardar el archivo.';
            header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
            exit;
        }

        $href = HOST_URL . '/api/adjuntos/' . $nombreArchivo;
    }

    $query = "INSERT INTO tareas (titulo, publicada, descripcion, fecha_publicacion, fecha_entrega, ID_asignatura, href)
              VALUES (?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conex->prepare($query);

    if (!$stmt) {
        $_SESSION['tarea_error'] = "Error en la preparación de la consulta: " . $conex->error;
        header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
        exit;
    }

    $stmt->bind_param("ssssis", $titulo, $publicada, $descripcion, $fecha_entrega, $id_asignatura, $href);

    if ($stmt->execute()) {
        $_SESSION['tarea_creada'] = true;
        header("Location: ../app/Asignatura_Seleccionada_tareas_Profesor.php?id=" . urlencode($id_asignatura));
        exit;
    } else {
        $_SESSION['tarea_error'] = "Error al guardar la tarea: " . $stmt->error;
        header("Location: ../app/Crear_Tarea.php?ID_asignatura=" . urlencode($id_asignatura));
        exit;
    }
}

procesarAdjunto();
