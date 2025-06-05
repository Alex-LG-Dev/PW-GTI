<?php
// Base de datos GTI
try {
    $conexion = mysqli_connect("localhost", "root", "", "gti");
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conexion->set_charset("utf8");
} catch (Exception $e) {
    
    die("Error al conectar con la base de datos. Contacta al administrador.");
}
?>
