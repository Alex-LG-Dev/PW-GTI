<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN GTI</title>
  <link rel="stylesheet" href="./app/css/estilos_LoginGTI.css">
</head>
<body class="body-login">
  <!-- panel izquierdo-->
  <div class="panel-izquierdo">
    <a href="./index.php"><img src="./img/logoGTI.png" alt="Logo de GTI"></a>
    <p>Conectamos docentes y alumnos con los mejores módulos educativos</p>
  </div>

  <!-- panel derecho -->
  <div class="panel-derecho">
    <div class="cuadrado-login">
      <h2>LOG<span class="in">IN</span></h2>
      <!-- FORMULARIO -->
      <form action="login.php" method="POST">
        <label for="email">Email</label>
        <input  type="email" id="email" name="email" placeholder="Ingresa Email">
        <label for="password">Contraseña</label>
        <input  type="password" id="password" name="password" placeholder="Ingresa Contraseña">
        <button type="submit" class="botonGTI">Iniciar Sesión</button>
      </form>
    </div>
  </div>
</body>
</html>
