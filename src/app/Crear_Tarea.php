<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_jose.css">
    <link rel="stylesheet" href="../app/css/estilos_combinados.css">
    <script src="../js/botonpublico.js" defer></script>
    <script src="../js/nombrecabezera.js" defer></script>
    <title>PROA | Crear Tarea</title>
</head>

<body>
<!-- ===============================  CABECERA  =============================== -->
    <?php include('encabezadoPROAprofesor.php'); ?>

<!-- ============================  MIGAS DE PAN  ============================= -->
<nav class="migas-de-pan">
  <p><a href="home-page-profesor.html">Inicio</a> &gt; Matemáticas</p>
</nav>
<!-- ==========================  CONTENIDO PÁGINA  =========================== -->
  <div class="titulo-asignatura">
    <h1>Crear Tarea Matematicas</h1>
  </div>
  <main>
    <!-- Crear Tarea -->
    <form class="form-crear-tarea" id="form" method="POST" action="../bbdd/insertar_Tarea.php" enctype="multipart/form-data">
      <div class="form-interior">
        <label for="titulo">Título de la tarea</label>
        <input name="titulo" type="text" id="titulo" placeholder="Inserte aquí el titulo" />

      </div>
      <!-- Fecha -->
      <div class="form-div-fecha">
        <div class="form-interior">
          <label for="fecha">Fecha entrega</label>
          <input name="fecha" type="date" id="fecha" />
        </div>
        <div class="form-interior">
            <label for="hora">Hora</label>
            <input name="hora" type="time" id="hora" />
        </div>
        <input type="file" name="adjunto" id="adjunto">
        <div class="boton-publico-div">
          <span class="publicar">Publicar:</span>
          <button type="button" id="boton-publico-img" class="toggle-publico">
            <img src="../img/publico-tarea.png" alt="publico" class="boton-publico">
          </button>
        </div>
        <input type="hidden" name="publicada" id="publicada" value="Sí" />
        <input type="hidden" name="ID_asignatura" value="1" />

      </div>
      
      <!-- Descripción -->

      <div class="form-interior">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="6"></textarea>
      </div>
      <!-- Botón guardar -->
      <div class="boton-guardar-form">
        <p class="warnings" id="warnings"></p>
        <input type="submit" class="guardar" value="guardar"></input>
        
      </div>
      <?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
<?php
session_start();
$error = $_SESSION['tarea_error'] ?? '';
unset($_SESSION['tarea_error']);
?>
<?php if ($error): ?>
  <div class="warnings" style="color:red; text-align:center; margin-bottom:1em;">
    <?php echo htmlspecialchars($error); ?>
  </div>
<?php endif; ?>
    </form>
  </main>


</body>
</html>