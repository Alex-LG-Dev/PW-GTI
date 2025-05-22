<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Pagina de Inicio Alumno PROA">
  <title>pagina sobre nosotros GTI</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/src/app/css/estiloGTI.css">
  <script src="../js/code.js" defer></script>
  <!-- Enlaza archivo JavaScript con atributo defer (se ejecuta después del HTML) -->
</head>

<body>
<!-- Aqui va el encabezado-->
  <?php include('encabezado_SiSesion.php'); ?>
<!-- Termina el header-->

<!-- Sección "Sobre Nosotros" -->
<section class="sobre-nosotros">
  <div class="introduccion">
    <div class="sn-img-izq">
      <!-- Imagen decorativa izquierda -->
      <img src="../img/sn-img-izq.png" alt="Imagen izquierda">
    </div>
    <div class="sn-texto">
      <!-- Contenido textual principal -->
      <h2>Sobre nosotros</h2>
      <!-- Título de la sección -->
      <p>Ayudamos a conectar docentes y alumnos con módulos educativos mediante una interfaz intuitiva, accesible y cómoda.</p>
      <!-- Descripción de la empresa -->
      <div class="iconos-contactos">
        <!-- Contenedor de información de contacto -->
        <div><img src="../img/email-icono.png" alt="Imagen izquierda"> GTI@gmail.com</div>
        <!-- Email con icono -->
        <div><img src="../img/tlf-icono.png" alt="Imagen izquierda"> +34 624589078</div>
        <!-- Teléfono con icono -->
        <div><img src="../img/usuarios-icono.png" alt="Imagen izquierda"> +100 instituciones ayudadas</div>
        <!-- Estadística con icono -->
      </div>
    </div>
    <div class="sn-img-der">
      <img src="../img/sn-img-der.png" alt="Imagen derecha">
    </div>
  </div>
</section>
<!-- Sección de Misión y Objetivos -->
<section class="mision-objetivo">
  <div class="sn-container">
    <img src="../img/sn-mision-objetivos.png" alt="Reunión de trabajo">
    <div class="sn-texto-mision">
      <h3>Nuestra Misión</h3>
      <p>En GTI nos dedicamos a impulsar la transformación digital de las instituciones educativas mediante el desarrollo de páginas web innovadoras, funcionales y accesibles. Nuestro objetivo es crear plataformas que fortalezcan la comunicación, y optimicen la gestión académica.</p>
      <h3>Objetivo</h3>
      <p>Nuestro objetivo es ofrecer productos digitales de alta calidad que satisfagan las necesidades de sus usuarios, destacándose en el mercado de las páginas web académicas. A través de la innovación y la excelencia en el desarrollo, busca diferenciarse de la competencia y asegurar el crecimiento sostenible de la empresa en el ámbito digital.</p>
    </div>
  </div>
</section>

<!-- Script adicional para funcionalidad del header -->
<script src="../js/nombrecabezera.js"></script>
</body>
</html>