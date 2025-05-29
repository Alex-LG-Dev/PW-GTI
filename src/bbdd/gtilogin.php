<?php

echo "<!-- Conexión a la base de datos PROA primero-->";
if (!empty($_POST['botonLogin'])) {
    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        
        exit;
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include("conexionbasesPROA.php");

    // Consulta segura solo con email y contraseña
    $stmt = $conexion->prepare("SELECT contrasena FROM usuarios_registrados WHERE email = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        // Verifica la contraseña (texto plano)
        if ($contrasena === $hash) {
            session_start();
            $_SESSION['usuario'] = $usuario;

            // Redirección genérica
            header("Location: ../app/homepage.php");
            exit;
        } 
    } 
    $stmt->close();
}


?>





