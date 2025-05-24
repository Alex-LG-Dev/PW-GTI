<?php
include('con_bdformulariocontacto.php');

$errores = [];

if (isset($_POST['enviar'])) {
    // Sanitizar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['correo'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $producto = !empty($_POST['productos']) ? trim($_POST['productos']) : NULL;

    // Validaciones
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    } elseif (strlen($nombre) > 120) {
        $errores[] = "El nombre no puede exceder 120 caracteres.";
    }

    if (empty($email)) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    } elseif (strlen($email) > 250) {
        $errores[] = "El correo no puede exceder 250 caracteres.";
    }

    if (empty($mensaje)) {
        $errores[] = "El mensaje es obligatorio.";
    }

    if (!empty($producto) && strlen($producto) > 60) {
        $errores[] = "El producto no puede exceder 60 caracteres.";
    }

    // Si no hay errores, insertar en la BD
    if (empty($errores)) {
        $stmt = $conex->prepare("INSERT INTO formulariocontacto (nombre, email, motivo, modulo) VALUES (?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $email, $mensaje, $producto);
            
            if ($stmt->execute()) {
                echo "<p class='success'>Mensaje enviado correctamente.</p>";
            } else {
                $errores[] = "Error al enviar el mensaje: " . $conex->error;
            }
            
            $stmt->close();
        } else {
            $errores[] = "Error en la consulta SQL: " . $conex->error;
        }
    }
    
    // Mostrar errores si los hay
    if (!empty($errores)) {
        echo "<div class='error'><ul>";
        foreach ($errores as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul></div>";
    }
}
?>



