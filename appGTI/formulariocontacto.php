<?php
include('con_bdformulariocontacto.php');

if (isset($_POST['register'])) {
    if (strlen($_POST['nombre']) >= 1 && strlen($_POST['correo']) >= 1) {

        // Sanitizar datos
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['correo'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');

        // Cambia los nombres de los campos para que coincidan con la tabla
        $consulta = "INSERT INTO formulariocontacto (nombre, email, motivo) VALUES ('$nombre', '$email', '$mensaje')";
        $resultado = mysqli_query($conex, $consulta);

        if ($resultado) {
            echo "<p class='success'>Mensaje enviado correctamente.</p>";
        } else {
            echo "<p class='error'>Error al enviar el mensaje: " . mysqli_error($conex) . "</p>";
        }
    }
}
?>



