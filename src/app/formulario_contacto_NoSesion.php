<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de contacto">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="../js/code.js" defer></script>
    <script src="../js/contacto.js" defer></script>
    <title>GTI | Contacto</title>
    <link rel="stylesheet" href="css/estiloGTI.css">
</head>
<body>

<!-- Aqui va el encabezado-->
  <?php include('encabezado_NoSesion.php'); ?>

  

<!-- Termina el header-->

    <!--Aqui va el formulario-->
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
            <!--Aqui van los campos del formulario-->
            <form id="form" class="form-contacto" method="post">
                <fieldset>
                    <!--texto descriptivo del formulario que mejora la accesiblidad y que despues se ocultara con css-->
                    <legend>Datos de contacto</legend>
                    <!--Campo de nombre-->
                    <label for="nombreUsuario">Nombre y Apellidos</label>
                    <input id="nombreUsuario" type="text" placeholder="Escribe aqui tu nombre" name="nombre" autocomplete="name" required>
                    <!--Campo de correo-->
                    <label for="email">Correo institucional</label>
                    <input id="email" type="email" placeholder="Ej: correo@institucional" name="correo" autocomplete="email" required>
                    <!--Campo de mensaje del formulario-->
                    <label for="motivo">Motivo</label>
                    <textarea id="motivo" placeholder="Escribe aqui tu duda" name="mensaje" required></textarea>
                    <!--campo desplegable del producto que quiere pedir-->
                    <label for="productos">Producto</label>
                    <select name="productos" id="productos"> 
                        <option value="">Elija un Producto</option>
                        <option value="producto-1">Modulo Tareas</option>
                        <option value="producto-2">Modulo Calendario</option>
                        
                    </select>
                    <!--boton que permite enviar el formulario-->
                    <button type="submit" class="botonGTI" name="enviar">Enviar</button>
                    <!-- Mensajes de advertencia -->
                    <p class="warnings" id="warnings"></p>
                </fieldset>
            </form>
            <?php include('../bbdd/formulariocontacto.php'); ?>
          </div>
      </section>

    </main>
</body>
</html>