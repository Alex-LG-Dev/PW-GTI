<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_jose.css">
    <script src="../js/code.js" defer></script>
    <link rel="stylesheet" href="css/estilos_combinados.css">
    <title>PROA | Matematicas</title>
</head>
    <?php include('encabezadoPROAalumno.php'); ?>

<body>
<!-- CABECERA DE LA PÁGINA ---------------------------------->
 <!-- ============================  MIGAS DE PAN  ============================= -->
<nav class="migas-de-pan">
 <a href="home-page-alumno.html">Inicio</a> &gt; <a href="Asignatura_Seleccionada_Matematicas_Alumno.html">Matematicas</a> &gt; Tareas</p>
</nav>
<!-- ==========================  CONTENIDO PÁGINA  =========================== -->
<div class="encabezado-tareas">
  <h1>Tareas Matemáticas</h1>

  <!-- Buscador -->
  <label class="caja-busqueda">
      <span class="icono-busqueda"></span>
      <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
  </label>
</div>
<!-- ============================  LISTA DE TAREAS  ============================= -->
    <ul class="lista-tareas-asignatura">
    <!-- Tarjeta 1 -->
    <li class="tarea">
      <div class="contenedor-tarea-header">
      <div class="tarea-header">
        <h2>Tarea 1. Conjuntos y vectores</h2>
        <span>6/04/2025 23:55</span>
      </div>
      <div class="div-toggle">
        <span class="nota">7.5/10</span>
        <img class="toggle" src="../img/flecha-abajo.png" alt="flecha-abajo">
      </div>
      </div>
      <div class="detalles-tarea oculto">
        <p class="p-descripcion">Descripción:</p>
        <p>Los conjuntos agrupan elementos similares...</p>        
        
      </div>
    </li>
    <!-- Tarjeta 2 -->
    <li class="tarea">
      <div class="contenedor-tarea-header">
      <div class="tarea-header">
        <h2>Tarea 2. Conjuntos y vectores</h2>
        <span>6/04/2025 23:55</span>
      </div>
      <div class="div-toggle">
        <span class="nota">7.5/10</span>
        <img class="toggle" src="../img/flecha-abajo.png" alt="flecha-abajo">
      </div>
      </div>
      <div class="detalles-tarea oculto">
        <p class="p-descripcion">Descripción:</p>
        <p>Los conjuntos agrupan elementos similares...</p>        
      </div>
    </li>
    <!-- Tarjeta 3 -->
    <li class="tarea">
      <div class="contenedor-tarea-header">
      <div class="tarea-header">
        <h2>Tarea 3. Introducción conjuntos</h2>
        <span>6/04/2025 23:55</span>
      </div>
      <div class="div-toggle">
        <span class="nota">0/10</span>
        <img class="toggle" src="../img/flecha-abajo.png" alt="flecha-abajo">
      </div>
      </div>
      <div class="detalles-tarea oculto">
        <p class="p-descripcion">Descripción:</p>
        <p>Los conjuntos agrupan elementos similares...</p>        
        <form class="responder-tarea">
          <label for="respuesta1"><strong>Tu respuesta:</strong></label>
          <textarea id="respuesta1"></textarea>
          <button type="submit"><img src="../img/enviar.png" alt="enviar.png">Enviar</button>
        </form>
      </div>
    </li>

    
  </ul>

  <!-- Script externo -->
  <script src="../js/tareas.js"></script>
   <script src="../js/nombrecabezera.js"></script>
</body>
</html>