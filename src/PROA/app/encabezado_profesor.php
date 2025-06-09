<?php
session_start();

// Includes originales imprescindibles
include __DIR__ . '/../api/proa_login.php';
include __DIR__ . '/../api/conexion_bd_proa.php';

// Validación de sesión
if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
    echo "<p>Error: Sesión no iniciada.</p>";
    header('Location: login_proa.php');
    exit();
}

$dni = $_SESSION['dni'];

// Obtener asignaturas del profesor, agrupadas por curso
$sql = "
    SELECT 
      a.ID_asignatura, 
      a.nombre, 
      a.curso
    FROM asignaturas a
    INNER JOIN matriculas_profesor mp 
      ON mp.ID_asignatura = a.ID_asignatura
    WHERE mp.DNI = ?
    ORDER BY a.curso ASC, a.nombre ASC
";
$stmt = $conex->prepare($sql);
$stmt->bind_param('s', $dni);
$stmt->execute();
$res = $stmt->get_result();

$asignaturasPorCurso = [];
while ($row = $res->fetch_assoc()) {
    $asignaturasPorCurso[$row['curso']][] = $row;
}

// Nombre para el header
$nombre = htmlspecialchars($_SESSION['nombre'] ?? 'Profesor');
?>
<header class="encabezado">
  <!-- Logo -->
  <div class="contenedor-logo">
    <a href="./home_page_profesor.php">
      <img src="../img/logo_proa.png" alt="Logo de PROA" class="logotipo">
    </a>
  </div>

  <!-- Menú desplegable de asignaturas -->
  <nav class="navegacion">
    <details class="desplegable">
      <summary class="boton-desplegable">ASIGNATURAS</summary>
      <div class="panel-asignaturas">
        <h3>Tus asignaturas 24/25</h3>
        <?php foreach ($asignaturasPorCurso as $curso => $asigs): ?>
          <details class="curso">
            <summary class="titulo-curso"><?= htmlspecialchars($curso) ?>º</summary>
            <?php foreach ($asigs as $a): ?>
              <a href="asignatura_seleccionada_profesor.php?id=<?= $a['ID_asignatura'] ?>">
                <?= htmlspecialchars($a['nombre']) ?>
              </a>
            <?php endforeach; ?>
          </details>
        <?php endforeach; ?>
      </div>
    </details>
  </nav>

  <!-- Info usuario -->
  <div class="contenedor-usuario">
    <span class="username"><?= $nombre ?></span>
    <img src="../img/user.png" alt="Avatar de usuario" class="icono">
    <a href="./login_proa.php">
      <img src="../img/cerrar_sesion.svg" alt="Cerrar sesión" class="icono icono-cerrar-sesion">
    </a>
  </div>
</header>
