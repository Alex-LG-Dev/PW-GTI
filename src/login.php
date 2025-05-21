<?php
session_start();
require_once './config.php';

// 1. Configuración y conexión a la base de datos (SQLite)
try {
    $pdo = new PDO(
        'sqlite:' . __DIR__ . '\bbdd\BaseDatosprueba.bd'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit('Error conectando a la base de datos.');
}

// Variables para mantener el estado del formulario
$error = '';
$email = '';
$contrasena = '';

// 2. Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email      = trim($_POST['email']?? '');
    $contrasena = trim($_POST['contrasena']?? '');

    // Validaciones básicas
    if (empty($email) || empty($contrasena)) {
        $error = 'Por favor, complete todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no tiene un formato válido.';
    } else {
        // Consulta segura con prepared statement
        $stmt = $pdo->prepare('
            SELECT id, nombre, password_hash
            FROM UsuariosGTI
            WHERE email = :email
            AND estado = 1
            LIMIT 1
        ');
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        // Verificar contraseña
        if ($usuario && password_verify($contrasena, $usuario['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nombre'];
            header('Location: dashboard.php');
            exit;
        }

        $error = 'Correo o contraseña incorrectos.';
    }
}
?>
<!-- 3. SALIDA HTML (formulario + mensajes)-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <title>LOGIN GTI</title>
  <script src="../js/code.js" ></script>
  <link rel="stylesheet" href="./app/css/estilos_LoginGTI.css">
</head>
<body class="body-login">
  <!--Esto es el panel de la izquierda-->
  <div class="panel-izquierdo">
    <a href="index.php">
      <img src="./img/logoGTI.png" alt="Logo de GTI">
    </a>
    <p>Conectamos docentes y alumnos con los mejores módulos educativos</p>
  </div>

  <!--Esto es el panel de la derecha-->
  <div class="panel-derecho">
    <div class="cuadrado-login">
      <h2>LOG<span class="in">IN</span></h2>
      <form>
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Ingresa Email">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="Ingresa Contraseña">
        <input type="button" value="Iniciar Sesión" class="botonGTI" onclick="loguearGTI()">
      </form>
    </div>
  </div>
  <!-- Script externo -->
  <script src="../js/code.js"></script>
</body>
</html>