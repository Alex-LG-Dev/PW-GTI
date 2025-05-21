<?php
// config.php — Conexión a SQLite para GTI

// Para mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // 1. Ruta al fichero .bd
    $rutaBD = __DIR__ . '\bbdd\BaseDatosprueba.bd';

    // 2. Depuración inicial: comprueba existencia
    if (! file_exists($rutaBD)) {
        exit("Error: fichero de base de datos no encontrado en: $rutaBD");
    }

    // 3. Instancia PDO apuntando al fichero SQLite
    $pdo = new PDO(
        'sqlite:' . $rutaBD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // mostrar mensaje y loguear el error real
    exit('Error conectando a la base de datos.');
}
