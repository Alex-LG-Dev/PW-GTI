<?php
// filepath: c:\Users\Soufiane\Documents\git\PW-GTI\src\bbdd\verificar.php
include("conexionBDGTI.php");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar usuario con ese token
    $stmt = $conexion->prepare("SELECT id FROM usuarios_registrados WHERE token_verificacion = ? AND verificado = 0");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Marcar como verificado
        $update = $conexion->prepare("UPDATE usuarios_registrados SET verificado = 1 WHERE token_verificacion = ?");
        $update->bind_param("s", $token);
        $update->execute();

        echo "¡Cuenta verificada correctamente! Ya puedes iniciar sesión.";
    } else {
        echo "Token inválido o la cuenta ya está verificada.";
    }
    $stmt->close();
    $conexion->close();
} else {
    echo "Token no proporcionado.";
}
?>