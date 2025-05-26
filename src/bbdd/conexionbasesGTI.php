<?php
// filepath: c:\xampp\htdocs\bbdd\conexionbasesPROA.php

try {
    $conex = mysqli_connect("localhost", "root", "", "gti");
    if (!$conex) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    $conex->set_charset("utf8");
    // Mensaje temporal para saber si la conexión fue exitosa
    echo "<!-- Conexión exitosa a la base de datos -->";
} catch (Exception $e) {
    echo "Fallo la conexión: " . $e->getMessage();
}
?>