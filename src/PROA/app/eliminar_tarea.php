<?php
session_start();
include('../api/conexion_bd_proa.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTarea = isset($_POST['id_tarea']) ? intval($_POST['id_tarea']) : null;
    $idAsignatura = isset($_POST['id_asignatura']) ? intval($_POST['id_asignatura']) : null;

    if (!$idTarea || !$idAsignatura) {
        $_SESSION['tarea_error'] = "Datos incompletos para eliminar la tarea.";
        header("Location: Asignatura_Seleccionada_tareas_Profesor.php?id=" . urlencode($idAsignatura));
        exit();
    }

    try {
        // Elimina respuestas asociadas
        $stmt = $conex->prepare("DELETE FROM respuesta_tareas WHERE ID_tarea = ?");
        $stmt->bind_param("i", $idTarea);
        $stmt->execute();
        $stmt->close();

        // Elimina la tarea
        $stmt = $conex->prepare("DELETE FROM tareas WHERE ID_tarea = ?");
        $stmt->bind_param("i", $idTarea);
        $stmt->execute();
        $stmt->close();

        $_SESSION['tarea_eliminada'] = true;
    } catch (Exception $e) {
        $_SESSION['tarea_error'] = "Error al eliminar la tarea: " . $e->getMessage();
    }

    header("Location: Asignatura_Seleccionada_tareas_Profesor.php?id=" . urlencode($idAsignatura));
    exit();
}

$_SESSION['tarea_error'] = "Acceso no válido.";
header("Location: Asignatura_Seleccionada_tareas_Profesor.php");
exit();
?>
