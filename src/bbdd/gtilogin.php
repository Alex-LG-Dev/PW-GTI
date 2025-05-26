<?php
if (!empty($_POST['botonLogin'])) {
    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        echo "<script>alert('Por favor, completa todos los campos.');window.history.back();</script>";
        exit;
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include(__DIR__ . "/conexionbasesGTI.php");

    // Consulta segura con el correo electrónico
    $stmt = $conex->prepare("SELECT contrasena FROM `usuarios_registrados` WHERE email= ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        // Verificación de la contraseña (texto plano en este caso)
        if ($contrasena === $hash) {
            session_start();
            $_SESSION['usuario'] = $usuario;

            // Redirección genérica sin importar el rol
            header("Location: app/HomepageGTI.php");
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta.');window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');window.history.back();</script>";
    }

    $stmt->close();
}
?>
