<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botonLogin'])) {

    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        echo "<script>alert('Usuario y contraseña son obligatorios.'); window.history.back();</script>";
        exit;
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include(__DIR__ . "/conexionbasesPROA.php");

    if (!$conexion) {
        echo "<script>alert('Error de conexión a la base de datos.'); window.history.back();</script>";
        exit;
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
            echo "<script>alert('Usuario o contraseña incorrectos.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
    $conexion->close();

} else {
    header("Location: ../login.php");
    exit;
}
