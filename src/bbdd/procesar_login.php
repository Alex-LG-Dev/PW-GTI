<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botonLogin'])) {

    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        die("Usuario y contraseña son obligatorios.");
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include(__DIR__ . "/conexionbasesPROA.php");

    if (!$conexion) {
        die("Error de conexión a la base de datos.");
    }

    // Preparar consulta para obtener usuario por email
    $stmt = $conexion->prepare("SELECT email, contrasena, nombre FROM usuarios_registrados WHERE email = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $fila = $result->fetch_assoc();

        // Verificar la contraseña con password_verify
        if (password_verify($contrasena, $fila['contrasena'])) {
            $_SESSION['usuario'] = $fila['email'];
            $_SESSION['user_name'] = $fila['nombre'];
            header("Location: ../app/homepageGTI.php");
            exit;
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conexion->close();

} else {
    header("Location: ../login.php");
    exit;
}