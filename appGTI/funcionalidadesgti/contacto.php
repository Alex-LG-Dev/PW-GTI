<?php
include('apigti/conexionbdgti.php');
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir datos
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    $producto = $_POST['producto'] ?? '';

    // Validar
    if (empty($nombre) || empty($email) || empty($motivo) || empty($producto)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Insertar usando prepared statement
    $stmt = $conexion->prepare("INSERT INTO consultas_contacto (nombre, email, motivo, producto) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta.']);
        exit;
    }

    $stmt->bind_param("ssss", $nombre, $email, $motivo, $producto);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Consulta enviada correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al enviar la consulta.']);
    }

    $stmt->close();
    $conexion->close();
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
