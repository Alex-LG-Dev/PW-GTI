<?php
// 1) Arrancamos la sesión antes de todo
session_start();

// 2) Incluimos tu login (donde asignas $_SESSION['nombre'])
require_once __DIR__ . '/../bbdd/Proalogin.php';

// 3) Obtenemos un valor por defecto si no existe la clave
$nombre = $_SESSION['nombre'] ?? 'Alumno';
?>
<header class="encabezado">
  <!-- Logo -->
  <div class="contenedor-logo">
    <a href="home-page-alumno.php">
      <img src="../img/Logo-Proa.png" alt="Logo de PROA" class="logotipo">
    </a>
  </div>

  <!-- Menú desplegable de asignaturas -->
  <nav class="navegacion">
    <details class="desplegable">
      <summary class="boton-desplegable" id="boton-desplegable-header">
        ASIGNATURAS
      </summary>
      <div class="panel-asignaturas">
        <h3>Asignaturas Matriculadas 24/25</h3>
        <details class="curso">
          <summary class="titulo-curso">1º</summary>
          <a href="Asignatura_Seleccionada_Matematicas_Alumno.php">Matemáticas</a>
          <a href="Asignatura_Seleccionada_Fisica_Alumno.php">Física</a>
          <a href="Asignatura_Seleccionada_Programacion_Alumno.php">Programación 1</a>
        </details>
      </div>
    </details>
  </nav>

  <!-- Info usuario -->
  <div class="contenedor-usuario">
    <span class="username"><?= htmlspecialchars($nombre) ?></span>
    <img src="../img/user.png" alt="Avatar de usuario" class="icono">
    <a href="loginPROA.php">
      <img src="../img/cerrarsesionGTI.png" alt="Cerrar sesión" class="icono icono-cerrar-sesion">
    </a>
  </div>
</header>
