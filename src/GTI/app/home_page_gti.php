<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo_gti.css">
   
    
    <title>GTI | Bienvenido a GTI</title>
</head>
<body>

<!-- Aqui va el encabezado-->
  <?php include('encabezado_si_sesion.php'); ?>

  <main class="main-home">
     <!-- Aquí comienza la sección del módulo de gestión de tareas -->
     <section class="section-home-modulo">
      <div class="home-modulo">
       <h2>Módulo de Gestión de Tareas</h2>
       <p>
         Un módulo educativo centrado en tareas, ideal para una página web educativa destinada a universidades. Este tipo de módulo se basa en el enfoque por tareas.
       </p>
       <!-- botón para acceder al catalogo de módulos -->
       <a href="catalogo_modulos_SiSesion.php" class="botonGTI">Ver módulos</a>
      </div>
        <img src="../img/chicahomepagegti.png"  alt="Mujer pensativa">
    </section>
    <!-- Aquí acaba la sección del módulo de gestión de tareas -->

    <!-- Aquí comienza la sección de la demo PROA -->
    <section class="section-home-demo">
      <div class="home-modulo">
      <h2>Prueba Nuestro Demo PROA</h2>
      <p>
        Ofrece a tus docentes y estudiantes una experiencia digital moderna, intuitiva y eficaz. Prueba nuestros módulos y transforma tu plataforma educativa en un entorno más dinámico, accesible y personalizado
      </p>
      <!-- botón para acceder a la demo -->
      <a href="./../../proa/app/login_proa.php" class="botonGTI" id="AccederDemo">Acceder</a>
      </div>
    </section>
  </main>
<!-- Script externo -->
</body>
</html>
