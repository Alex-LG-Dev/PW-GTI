<?php
if (!empty($_POST['botonLogin'])) {
    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        echo "<script>alert('Por favor, completa todos los campos.');window.history.back();</script>";
        exit;
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include("conexionbasesPROA.php");

    // Consulta segura usando LIKE y el email que introduce el usuario
    $stmt = $conex->prepare("SELECT rol, password FROM usuarios_registrados WHERE email = ?");
    $param = $usuario;
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($rol, $hash);
        $stmt->fetch();

        // Verifica la contraseña (texto plano)
        if ($contrasena === $hash) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $rol;

            // Redirige según el rol
            if ($rol === 'pas') {
                header("Location: ../app/home-page-pas.php");
            } elseif ($rol === 'profesor') {
                header("Location: ../app/home-page-profesor.php");
            } elseif ($rol === 'alumno') {
                header("Location: ../app/home-page-alumno.php");
            } 
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