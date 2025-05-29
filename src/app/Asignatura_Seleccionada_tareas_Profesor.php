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
 
<body>
<!-- CABECERA DE LA PÁGINA ---------------------------------->
     <?php include('encabezadoPROAprofesor.php'); ?>

<nav class="migas-de-pan">
  <p><a href="home-page-profesor.php">Inicio</a> &gt; Asignatura &gt; Tareas</p>
</nav>

<div class="encabezado-tareas">
  <h1>Tareas Matemáticas</h1>

<!-- Boton Crear Tarea -->
<a href="Crear_Tarea.php?ID_asignatura=1" class="botonPROA">Crear Tarea</a>

  <!-- Buscador -->
  <label class="caja-busqueda">
      <span class="icono-busqueda"></span>
      <input id="buscador-tarea" type="search" placeholder="Buscar tarea">
  </label>
</div>
    <ul class="lista-tareas-asignatura">
    <!-- Tarjeta 1 -->
    <li class="tarea">
      <div class="contenedor-tarea-header">
      <div class="tarea-header">
        <h2>Tarea 1. Conjuntos y vectores</h2>
        <span>06/04/2025 23:55</span>
      </div>
      <div class="div-toggle">
        
        <img class="toggle" src="../img/flecha-abajo.png" alt="flecha-abajo">
      </div>
      </div>
      <div class="detalles-tarea oculto">
        <p class="p-descripcion">Descripción:</p>
        <p>Los conjuntos agrupan elementos similares...</p>        
        <form class="responder-tarea responder-tarea-profesor">
            <a href="poner_NOTA.php"><img src="../img/check.png" alt="check.png">Calificar</a>
            <a href="Editar_Tarea.php"><img src="../img/lapizeditar.png" alt="Editar.png">Editar</a>
        </form>
      </div>
    </li>
    
    <!-- Tarjeta 2 -->
    <li class="tarea">
      <div class="contenedor-tarea-header">
      <div class="tarea-header">
        <h2>Tarea 2. Conjuntos y vectores</h2>
        <span>06/04/2025 23:55</span>
      </div>
      <div class="div-toggle">
        
        <img class="toggle" src="../img/flecha-abajo.png" alt="flecha-abajo">
      </div>
      </div>
      <div class="detalles-tarea oculto">
        <p class="p-descripcion">Descripción:</p>
        <p>Los conjuntos agrupan elementos similares...</p>        
        <form class="responder-tarea responder-tarea-profesor">
            <a href="poner_NOTA.php"><img src="../img/check.png" alt="check.png">Calificar</a>
            <a href="Editar_Tarea.php"><img src="../img/lapizeditar.png" alt="Editar.png">Editar</a>
        </form>
      </div>
    </li>

    <!-- Tarjeta 3 -->
    <li class="tarea">
      <div class="contenedor-tarea-header">
      <div class="tarea-header">
        <h2>Tarea 3. Introducción conjuntos</h2>
        <span>06/04/2025 23:55</span>
      </div>
      <div class="div-toggle">
        
        <img class="toggle" src="../img/flecha-abajo.png" alt="flecha-abajo">
      </div>
      </div>
      <div class="detalles-tarea oculto">
        <p class="p-descripcion">Descripción:</p>
        <p>Los conjuntos agrupan elementos similares...</p>        
        <form class="responder-tarea responder-tarea-profesor">
            <a href="poner_NOTA.php"><img src="../img/check.png" alt="check.png">Calificar</a>
            <a href="Editar_Tarea.php"><img src="../img/lapizeditar.png" alt="Editar.png">Editar</a>
        </form>
      </div>
    </li>

    
  </ul>

  <!-- Script externo -->
  <script src="../js/tareas.js"></script>
   <script src="../js/nombrecabezera.js"></script>
</body>