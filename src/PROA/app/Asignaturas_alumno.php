<?php
include('./encabezado_alumno.php');
include('../api/conexion_bd_proa.php');

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: login_proa.php");
    exit();
}

$dni = $_SESSION['dni'] ?? null;

$query = "
  SELECT 
      a.ID_asignatura,
      a.nombre AS nombre_asignatura,
      ur.nombre AS nombre_profesor,
      a.curso,
      (
          SELECT COUNT(*) FROM tareas t 
          WHERE 
              t.ID_asignatura = a.ID_asignatura 
              AND t.publicada = 'Sí' 
              AND t.fecha_entrega > NOW()
              AND t.ID_tarea NOT IN (
                  SELECT ID_tarea FROM respuesta_tareas WHERE ID_alumno = ?
              )
      ) AS tareas_pendientes
  FROM asignaturas a
  INNER JOIN matriculas_alumnos ma ON ma.ID_asignatura = a.ID_asignatura
  LEFT JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
  LEFT JOIN usuarios_registrados ur ON ur.dni = mp.DNI
  WHERE ma.DNI = ?
  ORDER BY a.curso, a.nombre
";

$stmt = $conex->prepare($query);
$stmt->bind_param("ss", $dni, $dni);
$stmt->execute();
$result = $stmt->get_result();

$asignaturas = [];
while ($row = $result->fetch_assoc()) {
    $asignaturas[$row['curso']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Asignaturas | Alumno</title>
  <link rel="stylesheet" href="./css/estilos_combinados.css">
  <script src="../js/asignaturas.js" defer></script>
</head>
<body class="body-fondo">

<nav class="migas_de_pan">
  <a href="./home_page_alumno.php">Inicio</a> &gt; Asignaturas
</nav>

<div class="contenedor-asignaturas">
  <div class="header-asignaturas">
    <h1>Asignaturas</h1>
    <div class="bloque-filtros">
      <div class="filtros-extra">
        <label for="filtro-nombre">Nombre:</label>
        <input type="search" id="filtro-nombre" placeholder="Buscar asignatura...">
      </div>
      <div class="filtros-opciones">
        <label class="label-filtro">Filtrar por curso:</label>
        <button class="filtro-btn" data-curso="1">Primero</button>
        <button class="filtro-btn" data-curso="2">Segundo</button>
        <button class="filtro-btn" data-curso="3">Tercero</button>
        <button class="filtro-btn" data-curso="4">Cuarto</button>
      </div>

      <div class="anio-actual">
        <span class="icono-anio"></span> 2024 - 2025
      </div>
    </div>
  </div>

  <?php foreach ([1, 2, 3, 4] as $curso): ?>
    <section class="bloque-asignaturas" data-curso="<?= $curso ?>">
      <div class="titulo-curso">
        <span class="numero-curso"><?= $curso ?></span>
        <h2><?= ['Primero', 'Segundo', 'Tercero', 'Cuarto'][$curso - 1] ?></h2>
        <button class="btn-toggle-curso">&#9650;</button>
      </div>

      <div class="tarjetas-asignaturas">
        <?php if (!empty($asignaturas[$curso])): ?>
          <?php foreach ($asignaturas[$curso] as $asignatura): ?>
            <div class="tarjeta-asignatura"
                 data-nombre="<?= strtolower($asignatura['nombre_asignatura']) ?>"
                 data-curso="<?= $curso ?>">
              <h3 class="nombre-asignatura">
                <?= htmlspecialchars($asignatura['nombre_asignatura']) ?>
                <span class="estrella-favorita">☆</span>
              </h3>
              <ul class="detalle-asignatura">
                <li>Prof. <?= htmlspecialchars($asignatura['nombre_profesor'] ?? 'Desconocido') ?></li>
                <li>Tareas pendientes: <?= (int)$asignatura['tareas_pendientes'] ?></li>
              </ul>
              <div class="footer-asignatura">
                <span class="creditos">6 Créd.</span>
                <a href="Asignatura_Seleccionada_tareas_Alumno.php?id=<?= $asignatura['ID_asignatura'] ?>" class="icono-ir">➜</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="sin-asignaturas">No hay asignaturas para este curso.</p>
        <?php endif; ?>
      </div>
    </section>
  <?php endforeach; ?>
</div>

</body>
</html>
