<?php

// Base de datos PROA
try {
    $conex = mysqli_connect("localhost", "root", "", "jmmarter_gestiontareasproa");
    if (!$conex) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conex->set_charset("utf8");
} catch (Exception $e) {
    echo "Fallo la conexión: " . $e->getMessage();
}

// Base de datos GTI
try {
    $conexion = mysqli_connect("localhost", "root", "", "jmmarter_gti");
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conexion->set_charset("utf8");
} catch (Exception $e) {
    
    die("Error al conectar con la base de datos. Contacta al administrador.");
}
?>
