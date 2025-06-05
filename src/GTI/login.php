<?php
// No incluir procesar_login.php aquí directamente, se llama desde el formulario al enviarse
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GTI | Login</title>
  <link rel="stylesheet" href="app/css/estiloGTI.css"> <!-- Asegúrate que exista -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="body-login">

  <?php include('app/encabezado_index.php'); ?>

  <section class="section-login">
    <div class="panel-izquierdo">
      <a href="index.php">
        <img src="img/logoGTI.png" alt="Logo de GTI">
      </a>
      <p>Conectamos docentes y alumnos con los mejores módulos educativos</p>
    </div>

    <div class="panel-derecho">
      <div class="cuadrado-login">
        <h2>LOG<span class="in">IN</span></h2>

        <form method="POST" action="bbdd/procesar_login.php">
          <label for="email">Email</label>
          <input type="email" id="email" name="usuario" placeholder="Ej: usuario@dominio.com" required>

          <label for="contrasena">Contraseña</label>
          <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required>

          <button type="submit" class="botonGTI" name="botonLogin">Iniciar Sesión</button>
        </form>

      </div>
    </div>
  </section>

</body>
</html>
