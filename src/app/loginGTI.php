<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <title>LOGIN GTI</title>
  <script src="../js/code.js" ></script>
  <link rel="stylesheet" href="css/estilos_LoginGTI.css">
</head>
<body class="body-login">
  <!--Esto es el panel de la izquierda-->
  <div class="panel-izquierdo">
    <a href="../index.html">
      <img src="../img/logoGTI.png" alt="Logo de GTI">
    </a>
    <p>Conectamos docentes y alumnos con los mejores módulos educativos</p>
  </div>
  <!--Esto es el panel de la derecha-->
  <div class="panel-derecho">
    <div class="cuadrado-login">
      <h2>LOG<span class="in">IN</span></h2>
      <form method="post">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Ingresa Email">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="Ingresa Contraseña">
        <input type="button" value="Iniciar Sesión" class="botonGTI" onclick="loguearGTI()">
      </form>
    </div>
  </div>
</body>
</html>
