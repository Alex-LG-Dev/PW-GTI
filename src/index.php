<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/css/estiloGTI.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="js/code.js" defer></script>
    <title>GTI | Los mejores modulos educativos</title>
    
</head>
<body>
  <!-- Aqui va el encabezado-->
  <?php include('app/encabezado_index.php'); ?>
  <!-- Termina el header-->
  <main>
  <!-- Aqui va el banner-->
  <section class="bannerGTI">
    <h1>Módulos Educativos GTI</h1>
    <p>Diseñados para impulsar la educación en tu institución</p>
    <a href="app/catalogo_modulos_NoSesion.html" class="botonGTI">Ver módulos</a>
  </section>
  <!-- Aqui termina el banner-->

  <!-- Aqui va la seccion con dos bloques-->
  <section class="registroGTI">
    <!-- Aqui va el bloque con info-->
    <div class="texto-demo">
      <h2>Prueba nuestra demo PROA</h2>
      <p>Verifícate con tu correo institucional para tener acceso a una prueba de nuestros módulos</p>
    </div>
    <!-- Aqui va el registro de GTI-->
    <div class="contenedor-registroGTI">
      <form id="form" class="formGTI">
        <label for="correo">Correo institucional</label>
        <input type="email" id="email" name="correo" required>

        <label for="usuario">Nombre de usuario</label>
        <input type="text" id="nombreUsuario" name="usuario" required>

        <label for="password">Contraseña</label>
        <input type="password" id="contraseña" name="password" required>

        <button type="submit" class="botonGTI">Registrarse</button>
        <p class="warnings" id="warnings"></p>
      </form>
    </div>
  </section>
  </main>
  <!-- Incluye el archivo JavaScript -->
  <script src="js/registro.js"></script>
</body>
</html>
