<?php
session_start();
require_once './config.php';

// 1. Configuración y conexión a la base de datos (SQLite)
try {
    $pdo = new PDO(
        'sqlite:' . __DIR__ . '\bbdd\BaseDatosprueba.bd'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  // Línea corregida
} catch (PDOException $e) {
    exit('Error conectando a la base de datos.');
}

// Variables para mantener el estado del formulario
$errorEmail = null;
$errorPassword = null;
$email = '';
$contrasena = '';

// 2. Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']?? '');
    $contrasena = trim($_POST['contrasena']?? '');

    // Validación del email primero
    if (empty($email)) {
        $errorEmail = 'Por favor, complete el email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = 'email incorrecto';
    } else {
        // Si el email es válido, verificamos en la base de datos
        $stmt = $pdo->prepare('
            SELECT id, nombre, password
            FROM UsuariosGTI
            WHERE email = :email
            AND estado = 1
            LIMIT 1
        ');
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Solo verificamos la contraseña si el email existe
            if ($contrasena === $usuario['password']) {
                session_regenerate_id(true);
                $_SESSION['user_id']   = $usuario['id'];
                $_SESSION['user_name'] = $usuario['nombre'];
                header('Location: app/HomepageGTI.php');
                exit;
            } else {
                $errorPassword = 'Contraseña incorrecta.';
            }
        } else {
            $errorEmail = 'Correo no encontrado.';
        }
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
      <form method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Escribe aqui tu email" required class="<?php echo (isset($errorEmail) && $_SERVER['REQUEST_METHOD'] === 'POST') ? 'input-error' : ''; ?>"> 
        <?php if (isset($errorEmail) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
          <p class="error-text"><?= htmlspecialchars($errorEmail) ?></p>
        <?php endif; ?>
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" value="<?= htmlspecialchars($contrasena) ?>" placeholder="escribe aqui tu contraseña" required class="<?php echo (isset($errorPassword) && $_SERVER['REQUEST_METHOD'] === 'POST') ? 'input-error' : ''; ?>">
        <?php if (isset($errorPassword) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
          <p class="error-text"><?= htmlspecialchars($errorPassword) ?></p>
        <?php endif; ?>
        <button type="submit" class="botonGTI">Iniciar Sesión</button>
      </form>
    </div>
  </div>
</body>
</html>