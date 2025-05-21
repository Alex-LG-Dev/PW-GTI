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
<header class="encabezado">
    <!-- Logo -->
    <div class="contenedor-logo">
        <a href="home-page-profesor.html"><img src="../img/Logo-Proa.png" alt="Logo de PROA" class="logotipo"></a>
    </div>

    <!-- Menú desplegable de asignaturas -->
    <nav class="navegacion">
      <details class="desplegable">
        <summary class="boton-desplegable" id="boton-desplegable-header">ASIGNATURAS</summary>

        <div class="panel-asignaturas">
          <h3>Asignaturas Asignadas 24/25</h3>
          <!-- Curso 1º -->
          <details class="curso">
            <summary class="titulo-curso">1º</summary>
            <a href="Asignatura_Seleccionada_Matematicas_Profesor.html">Matemáticas</a>
            <a href="Asignatura_Seleccionada_Fisica_Profesor.html">Física</a>
            <a href="Asignatura_Seleccionada_Programacion_Profesor.html">Programación 1</a>
          </details>
        </div>
      </details>
    </nav>

    <!-- Info usuario -->
    <div class="contenedor-usuario">
      <a class="username">Juan Pérez</a>
      <img src="../img/user.png" alt="Avatar de usuario" class="icono">
      <a href="loginPROA.html"><img src="../img/cerrarsesionGTI.png" alt="Cerrar sesión" class="icono icono-cerrar-sesion"></a>
    </div>
  </header>
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