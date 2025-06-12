<?php
session_start();
include('../api/conexion_bd_proa.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTarea = isset($_POST['id_tarea']) ? intval($_POST['id_tarea']) : null;
    $idAsignatura = isset($_POST['id_asignatura']) ? intval($_POST['id_asignatura']) : null;

    if (!$idTarea || !$idAsignatura) {
        echo "Asignatura no especificada.";
        exit();
    }

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
    // Redirige de vuelta
    header("Location: asignatura_seleccionada_tareas_profesor.php?id=" . urlencode($_POST['id_asignatura']));
    exit;
}

echo "Acceso no válido.";
