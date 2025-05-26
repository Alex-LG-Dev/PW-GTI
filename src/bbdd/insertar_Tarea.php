<?php
session_start();
include("conexionbasesPROA.php");
const HOST_URL= 'http://localhost';

function procesarAdjunto(){
    global $conex;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['tarea_error'] = 'No se ha enviado el formulario.';
        header("Location: ../app/Crear_Tarea.php");
        exit;
    }

    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $publicada = $_POST['publicada'] ?? 'No';
    $id_asignatura = $_POST['ID_asignatura'] ?? 1;

    if (empty($titulo) || empty($fecha) || empty($hora)) {
        $_SESSION['tarea_error'] = 'Por favor completa todos los campos requeridos.';
        header("Location: ../app/Crear_Tarea.php");
        exit;
    }

    $fecha_entrega = $fecha . ' ' . $hora;
    $href = null;
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        $fileUpload = $_FILES['adjunto'];
        $target_dir = "../bbdd/adjuntos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . basename($fileUpload["name"]);
        if (file_exists($target_file)) {
            $_SESSION['tarea_error'] = 'El archivo ya existe';
            header("Location: ../app/Crear_Tarea.php");
            exit;
        }
        $sizeLimit = 1024 * 1024 * 5;
        if ($fileUpload["size"] > $sizeLimit) {
            $_SESSION['tarea_error'] = 'El archivo adjunto es demasiado grande (max 5 MB)';
            header("Location: ../app/Crear_Tarea.php");
            exit;
        }
        if (!move_uploaded_file($fileUpload["tmp_name"], $target_file)) {
            $_SESSION['tarea_error'] = 'No se pudo guardar el archivo';
            header("Location: ../app/Crear_Tarea.php");
            exit;
        }
        $href = HOST_URL . '/bbdd/adjuntos/' . basename($fileUpload["name"]);
    }

    $query = "INSERT INTO tareas (titulo, publicada, descripcion, fecha_publicacion, fecha_entrega, ID_asignatura, href) 
              VALUES (?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conex->prepare($query);
    if (!$stmt) {
        $_SESSION['tarea_error'] = "Error en la preparación de la consulta: " . $conex->error;
        header("Location: ../app/Crear_Tarea.php");
        exit;
    }

    $stmt->bind_param("ssssis", $titulo, $publicada, $descripcion, $fecha_entrega, $id_asignatura, $href);

    if ($stmt->execute()) {
        // Éxito: redirige a la página de tareas
        header("Location: ../app/Asignatura_Seleccionada_tareas_Profesor.php");
        exit;
    } else {
        $_SESSION['tarea_error'] = "Error al guardar la tarea: " . $stmt->error;
        header("Location: ../app/Crear_Tarea.php");
        exit;
    }
}

procesarAdjunto();