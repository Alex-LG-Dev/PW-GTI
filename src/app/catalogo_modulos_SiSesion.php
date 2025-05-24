<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estiloGTI.css">
    <script src="../js/code.js" defer></script>
    <title>GTI | Nuestro Catálogo</title>
</head>
<body>
  <main>
<!-- Aqui va el encabezado-->
  <?php include('encabezado_SiSesion.php'); ?>

  <section class="catalogo">
    <h2>Nuestro catálogo</h2>
  
    <div class="contenedor-carrusel">
      <!-- Tarjeta: Tareas -->
      <div class="tarjeta">
  
        <div>
          <img src="../img/tareasGTI.png" alt="Módulo de Tareas">
          <div class="contenido">
            <h3>Tareas</h3>
            <p>
              Crea, edita y publica tareas como profesor y permite que tus alumnos puedan realizar sus tareas desde casa.
            </p>
          </div>
        </div>
  
       
      </div>
  
      <!-- Tarjeta: Calendario -->
      <div class="tarjeta">
        
        <div>
        <img src="../img/calendarioGTI.png" alt="Módulo de Calendario">
        <div class="contenido">
          <h3>Calendario</h3>
          <p>
            Con este módulo tus alumnos podrán organizarse mediante un calendario en su página de usuarios.
          </p>
        </div>
        </div>
      </div>
    </div>
  </section>
   <script src="../js/nombrecabezera.js"></script>
   </main>
</body>
</html>