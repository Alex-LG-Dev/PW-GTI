<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GTI | Registro</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../app/css/estilo_gti.css">
</head>
<body class="body-login">
  
<!-- Aqui va el encabezado-->
  <?php include('../app/encabezado_no_sesion.php'); ?>
<!-- Termina el header-->
  <section class="section-login">
<!--Esto es el panel de la izquierda-->
<div class="panel-izquierdo">
  <a href="../index.php">
    <img src="../img/logo_gti.png" alt="Logo de GTI">
  </a>
  <p>Conectamos docentes y alumnos con los mejores módulos educativos</p>
</div>
  <!--Esto es el panel de la derecha-->
  <div class="panel-derecho">
    <div class="cuadrado-login">
      <h2>SIGN<span class="in">UP</span></h2>
      <form id="form" action=".. /api/enviarCorreo.php" method="POST">
        <label for="nombreUsuario">Nombre Usuario</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" placeholder="Ingresa Nombre">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa Email">
        <label for="contraseña">Contraseña</label>
        <input type="password" id="contraseña" name="contraseña" placeholder="Ingresa Contraseña">
        <button type="submit" class="botonGTI">Registrarse</button>
        <p class="warnings" id="warnings"></p>
      </form>
    </div>
  </div>
  </section>
</body>
</html>