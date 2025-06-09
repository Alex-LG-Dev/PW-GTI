<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Formulario de contacto">
  <title>GTI | Contacto</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../app/css/estilo_gti.css">
  
  
  <!--<script src="../js/contacto.js" defer></script>-->
</head>
<body>

<!-- Aqui va el encabezado -->
<?php include('../app/encabezado_no_sesion.php'); ?>

<main>
  <section class="seccion-contacto">
    <div class="banner-contacto">
      <h2>CONTACTANOS</h2>
    </div>
    <div class="banner-contacto2">
      <h3>Empecemos nuestro diálogo</h3>
      <p>¿Te interesa alguno de nuestros módulos? Rellena este simple formulario con tus datos y así resolveremos tus dudas</p>
    </div>
    <div id="Formulario">
      <form id="form" class="form-contacto" action=".. /api/formulariocontactonosesion.php" method="POST">
        <label for="nombreUsuario">Nombre y Apellidos</label>
        <input id="nombreUsuario" type="text" placeholder="Escribe aqui tu nombre" name="nombre" autocomplete="name" required>

        <label for="email">Correo institucional</label>
        <input id="email" type="email" placeholder="Ej: correo@institucional" name="email" autocomplete="email" required>

        <label for="motivo">Motivo</label>
        <textarea id="motivo" placeholder="Escribe aqui tu duda" name="motivo" required></textarea>

        <label for="productos">Producto</label>
        <select name="producto" id="productos" required>
          <option value="">Elija un Producto</option>
          <option value="Modulo Tareas">Modulo Tareas</option>
          <option value="Modulo Calendario">Modulo Calendario</option>
        </select>

        <button type="submit" class="botonGTI">Enviar</button>
        <p class="warnings" id="warnings"></p>
      </form>
    </div>
  </section>
</main>  

</body>
</html>