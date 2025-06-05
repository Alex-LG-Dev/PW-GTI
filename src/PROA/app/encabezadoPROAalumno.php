<?php
session_start();
require_once __DIR__ . '/../bbdd/conexionBDPROA.php';
require_once __DIR__ . '/../bbdd/Proalogin.php';

$dni = $_SESSION['dni'] ?? null;
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
        <?php
        if ($dni) {
            $query = "
                SELECT a.nombre, a.curso, a.ID_asignatura 
                FROM asignaturas a
                INNER JOIN matriculas_alumnos ma ON ma.ID_asignatura = a.ID_asignatura
                WHERE ma.DNI = ?
                ORDER BY a.curso, a.nombre
            ";
            $stmt = $conex->prepare($query);
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $res = $stmt->get_result();

            $cursos = [];

            while ($row = $res->fetch_assoc()) {
                $curso = $row['curso'] ?: 'Sin curso';
                $cursos[$curso][] = $row;
            }

            foreach ($cursos as $curso => $asignaturas) {
                echo "<details class='curso'>";
                echo "<summary class='titulo-curso'>" . htmlspecialchars($curso) . "º</summary>";
                foreach ($asignaturas as $asignatura) {
                    $nombreAsignatura = htmlspecialchars($asignatura['nombre']);
                    $id = $asignatura['ID_asignatura'];
                    echo "<a href='Asignatura_Seleccionada_Alumno.php?id=$id'>$nombreAsignatura</a>";
                }
                echo "</details>";
            }
        } else {
            echo "<p class='linksAsignp'>No estás matriculado en asignaturas</p>";
        }
        ?>
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
