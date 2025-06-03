<?php
// formulariocontacto.php

include('conexionbasesPROA.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $motivo = mysqli_real_escape_string($conexion, $_POST['motivo']);
    $producto = mysqli_real_escape_string($conexion, $_POST['producto']);

    if (empty($nombre) || empty($email) || empty($motivo) || empty($producto)) {
        echo "<script>
                alert('Todos los campos son obligatorios.');
                window.location.href = '../app/formulario_contacto_SiSesion.php';
              </script>";
    } else {
        $sql = "INSERT INTO consultas_contacto (nombre, email, motivo, producto)
                VALUES ('$nombre', '$email', '$motivo', '$producto')";

        if (mysqli_query($conexion, $sql)) {
            echo "<script>
                    alert('Consulta enviada correctamente.');
                    window.location.href = '../app/formulario_contacto_SiSesion.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al enviar la consulta.');
                    window.location.href = '../app/formulario_contacto_SiSesion.php';
                  </script>";
        }
    }

    mysqli_close($conexion);
} else {
    echo "<script>
            alert('Acceso no permitido.');
            window.location.href = '../app/formulario_contacto_SiSesion.php';
          </script>";
}
?>
