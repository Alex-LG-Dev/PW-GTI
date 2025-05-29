<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botonLogin'])) {

    // Validación básica
    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        die("Usuario y contraseña son obligatorios.");
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    // Conexión a la base de datos
    include("conexionbasesPROA.php"); // Ajusta si está en otra ruta

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta segura con prepared statements
    $stmt = $conexion->prepare("SELECT email, contrasena, nombre FROM usuarios_registrados WHERE email = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $fila = $result->fetch_assoc();

        // Versión sin hash (si usas texto plano)
        if ($contrasena === $fila['contrasena']) {
            $_SESSION['usuario'] = $fila['email'];
            $_SESSION['user_name'] = $fila['nombre'];
            header("Location: ../app/HomepageGTI.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }

        // ⚠️ Si usas password_hash en la base de datos, usa esto en su lugar:
        /*
        if (password_verify($contrasena, $fila['contrasena'])) {
            $_SESSION['usuario'] = $fila['email'];
            $_SESSION['user_name'] = $fila['nombre'];
            header("Location: ../app/homepage.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
        */

    } else {
        echo "Usuario no encontrado o credenciales inválidas.";
    }

    $stmt->close();
    $conexion->close();

} else {
    // Si acceden directamente, redirigir al login
    header("Location: ../login.php");
    exit;
}
