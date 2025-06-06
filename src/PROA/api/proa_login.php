<?php
if (!empty($_POST['botonLogin'])) {
    if (empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        echo "<script>alert('Por favor, completa todos los campos.');window.history.back();</script>";
        exit;
    }

    $usuario = trim(strtolower($_POST['usuario']));
    $contrasena = trim($_POST['contrasena']);

    include("conexion_bd_proa.php");

    $stmt = $conex->prepare("SELECT dni, rol, password, nombre FROM usuarios_registrados WHERE email = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($dni, $rol, $hash, $nombre);
        $stmt->fetch();

        // Validación directa (puedes cambiar por password_verify si hasheas)
        if ($contrasena === $hash) {
            session_start();
            $_SESSION['usuario'] = $usuario; // email
            $_SESSION['rol'] = $rol;
            $_SESSION['dni'] = $dni;        
            $_SESSION['nombre'] = $nombre; 

            // Redirección por rol
            if ($rol === 'pas') {
                header("Location: ../app/home_page_pas.php");
            } elseif ($rol === 'profesor') {
                header("Location: ../app/home_page_profesor.php");
            } elseif ($rol === 'alumno') {
                header("Location: ../app/home_page_alumno.php");
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
