<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_jose.css">
    <link rel="stylesheet" href="../app/css/estilos_combinados.css">
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
    <form class="form-crear-tarea" id="form">
      <div class="form-interior">
        <label for="titulo">Título de la tarea</label>
        <input type="text" id="titulo" placeholder="Inserte aquí el titulo" />

      </div>
      <!-- Fecha -->
      <div class="form-div-fecha">
        <div class="form-interior">
          <label for="fecha">Fecha entrega</label>
          <input type="date" id="fecha" />
        </div>
        <div class="form-interior">
            <label for="hora">Hora</label>
            <input type="time" id="hora" />
        </div>
        <div class="boton-publico-div">
          <span class="publicar">Publicar:</span>
          <button type="button" id="boton-publico-img" class="toggle-publico">
            <img src="../img/publico-tarea.png" alt="publico" class="boton-publico">
          </button>
        </div>
      </div>
      <!-- Descripción -->

      <div class="form-interior">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" rows="6"></textarea>
      </div>
      <!-- Botón guardar -->
      <div class="boton-guardar-form">
        <p class="warnings" id="warnings"></p>
        <button type="submit" class="guardar">Guardar</button>
      </div>
    </form>
  </main>
<!-- Script externo -->
<script src="../js/botonpublico.js"></script>
<script src="../js/Crear_Tarea.js"></script>
 <script src="../js/nombrecabezera.js"></script>
</body>
</html>