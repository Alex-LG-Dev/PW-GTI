<!-- 3. SALIDA HTML (formulario + mensajes)-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <title>GTI | LogIn</title>
  <script src="js/code.js" defer></script>
  <link rel="stylesheet" href="app/css/estiloGTI.css">
</head>
<body class="body-login">
  <!-- Aqui va el encabezado-->
  <?php include('app/encabezado_index.php'); ?>
  <!-- Termina el header-->
   <section class="section-login">
  <!--Esto es el panel de la izquierda-->
  <div class="panel-izquierdo">
    <a href="index.php">
      <img src="img/logoGTI.png" alt="Logo de GTI">
    </a>
    <p>Conectamos docentes y alumnos con los mejores módulos educativos</p>
  </div>

  <!--Esto es el panel de la derecha-->
  <div class="panel-derecho">
    <div class="cuadrado-login">
      <h2>LOG<span class="in">IN</span></h2>
      
      <form method="post">
        <?php include('bbdd/gtilogin.php'); ?>
        <label for="email">Email</label>
        <input type="email" id="email" name="usuario" placeholder="Escribe aqui tu email" required>
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="escribe aqui tu contraseña" required>
        <button type="submit" class="botonGTI" name="botonLogin">Iniciar Sesión</button>
      </form>
    </div>
  </div>
  </section>
</body>
</html>