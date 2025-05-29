<?php
// filepath: c:\xampp\htdocs\bbdd\conexionbasesPROA.php

try {
    $conex = mysqli_connect("localhost", "root", "", "gestiontareasproa");
    if (!$conex) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conex->set_charset("utf8");
} catch (Exception $e) {
    echo "Fallo la conexión: " . $e->getMessage();
}
try {
    $conexion = mysqli_connect("localhost", "root", "", "gti");
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conexion->set_charset("utf8");
    echo "<!-- Conexión exitosa a la base de datos -->";
} catch (Exception $e) {
    echo "Fallo la conexión: " . $e->getMessage();
}
?>