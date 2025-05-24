<?php
if(!empty($_POST['botonLogin'])) {
    if(empty($_POST['usuario']) || empty($_POST['contrasena'])) {
        echo "<script>alert('Por favor, completa todos los campos.');</script>";
    } else {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Conexión a la base de datos
        include("conexionbasesPROA.php");

        // Consulta para verificar el usuario y la contraseña
        $sql = "SELECT rol FROM usuarios WHERE email='$usuario' AND contrasena='$contrasena'";
        $resultado = mysqli_query($conex, $sql);

        if(mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            $rol = $fila['rol'];

            // Redirigir según el rol usando JavaScript
            if ($rol == 'pas') {
                echo "<script>window.location.href='../app/home-page-pas.php';</script>";
            } elseif ($rol == 'profesor') {
                echo "<script>window.location.href='../app/home-page-profesor.php';</script>";
            } elseif ($rol == 'alumno') {
                echo "<script>window.location.href='../app/home-page-alumno.php';</script>";
            } else {
                echo "<script>alert('Rol no reconocido.');</script>";
            }
        } else {
            // Usuario o contraseña incorrectos
            echo "<script>alert('Usuario o contraseña incorrectos.');</script>";
        }
    }
}
?>