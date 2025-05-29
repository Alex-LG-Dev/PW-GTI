<?php
session_start(); // Movido al inicio

if (!empty($_POST['botonLogin'])) {
    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        echo "Usuario y contraseña son obligatorios.";
        exit;
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include("bbdd/conexionbasesPROA.php"); // Asegúrate de que la ruta es correcta

    // Consulta para obtener el usuario
    $sql = "SELECT email, contrasena FROM usuarios_registrados WHERE email = '$usuario' AND contrasena = '$contrasena'";
    $result = $conexion->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../app/homepage.php");
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
    $conexion->close(); // Cierra la conexión
}
?>
