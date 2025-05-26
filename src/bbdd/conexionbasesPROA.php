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
?>