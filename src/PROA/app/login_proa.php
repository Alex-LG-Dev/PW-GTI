<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN PROA</title>
  <link rel="stylesheet" href="./css/estilos_combinados.css">

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="body-loginproa">

  <!--Esto es el panel de la izquierda-->
  <div class="panel-izquierdo-login">
    <!--aqui va el logo-->
    <a href="../../gti/app/home_page_gti.php">
      <img src="../../proa/img/logo_proa.png" alt="Logo de PROA">
    </a>
    <!--aqui va el texto-->
    <p>Ayudamos a conectar docentes y alumnos con módulos educativos mediante una interfaz intuitiva, accesible y cómoda.</p>
  </div>
  <!--Esto es el panel de la derecha-->
  <div class="panel-derecho-login">
    <div class="cuadrado-login">
      <h2>Bienvenido a PROA</h2>
      <form method="post">
        <?php include('../api/Proa_login.php');
        include('../api/conexion_bd_proa.php');
        ?>
        <label for="usuario">Email</label>
        <input type="email" id="usuario" name="usuario" placeholder="Ingresa Email">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Ingresa Contraseña">
        <input type="submit" value="Iniciar Sesión" class="boton-login" name="botonLogin">
<a href="../../gti/app/home_page_gti.php" class="botonPROA">Volver a GTI</a>

      </form>

    </div>

  </div>

  <footer class="demo-footer">
    <p>Se encuentra en la demo de PROA</p>
    <p>Inicie sesión rápidamente como:</p>
    <div class="perfil-buttons">
      <button onclick="autocompletar('alumno')" class="botonPROA">alumno</button>
      <button onclick="autocompletar('profesor')" class="botonPROA">profesor</button>
      <button onclick="autocompletar('pas')" class="botonPROA">pas</button>
    </div>
  </footer>
</body>
<script>
  function autocompletar(perfil) {
    const datos = {
      alumno: {
        usuario: "l.simdre@epsg.upv.es",
        contrasena: "9218611"
      },
      profesor: {
        usuario: "k.poumai@upv.es",
        contrasena: "4525956"
      },
      pas: {
        usuario: "o.breshe@upv.es",
        contrasena: "1316390"
      }
    } [perfil];

    document.getElementById('usuario').value = datos.usuario;
    document.getElementById('contrasena').value = datos.contrasena;
  }
</script>

</html>