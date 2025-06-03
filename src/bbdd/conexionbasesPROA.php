<?php
// filepath: c:\xampp\htdocs\bbdd\conexionbasesPROA.php

try {
    $conex = mysqli_connect("localhost", "root", "", "jmmarter_gestiontareasproa");
    if (!$conex) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conex->set_charset("utf8");
} catch (Exception $e) {
    echo "Fallo la conexión: " . $e->getMessage();
}

// Conexión única a la BD relevante (eliminada la redundancia)
try {
    $conexion = mysqli_connect("localhost", "root", "", "jmmarter_gti");
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conexion->set_charset("utf8");
} catch (Exception $e) {
    // En producción, redirigir a un error genérico
    die("Error al conectar con la base de datos. Contacta al administrador.");
}
?>
