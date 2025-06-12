<?php

include('./encabezado_profesor.php');
include('../api/conexion_bd_proa.php');

if (!isset($_SESSION['dni']) || $_SESSION['rol'] !== 'profesor') {
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
      ) AS tareas_pendientes
  FROM asignaturas a
  INNER JOIN matriculas_profesor mp ON mp.ID_asignatura = a.ID_asignatura
  LEFT JOIN usuarios_registrados ur ON ur.dni = mp.DNI
  WHERE mp.DNI = ?
  ORDER BY a.curso, a.nombre
";

$stmt = $conex->prepare($query);
$stmt->bind_param("s", $dni);
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

<body class="fondo-asignaturas-alumno">

  <nav class="migas_de_pan">
    <a href="./home_page_profesor.php">Inicio</a> &gt; Asignaturas
  </nav>

  <div class="contenedor-asignaturas-alumno">
    <div class="cabecera-asignaturas">
      <h1>Asignaturas</h1>
      <div class="filtros-asignaturas">
        <div class="filtro-nombre-asignatura">
          <label for="filtro-nombre">Nombre:</label>
          <input type="search" id="filtro-nombre" placeholder="Buscar asignatura...">
        </div>
        <div class="filtro-curso-asignatura">
          <label>Filtrar por curso:</label>
          <button class="btn-curso-filtro" data-curso="1">Primero</button>
          <button class="btn-curso-filtro" data-curso="2">Segundo</button>
          <button class="btn-curso-filtro" data-curso="3">Tercero</button>
          <button class="btn-curso-filtro" data-curso="4">Cuarto</button>
        </div>
        <div class="anio-academico-asignatura">
          <span class="icono-anio"></span> 2024 - 2025
        </div>
      </div>
    </div>

    <?php foreach ([1, 2, 3, 4] as $curso): ?>
      <section class="bloque-curso-asignaturas" data-curso="<?= $curso ?>">
        <div class="contenedor-curso-centrado">

          <div class="encabezado-curso-asignatura">
            <div class="info-curso-asignatura">
              <span class="numero-curso-asignatura"><?= $curso ?></span>
              <?= ['Primero', 'Segundo', 'Tercero', 'Cuarto'][$curso - 1] ?>
            </div>
            <button class="btn-toggle-curso">▼</button>
          </div>

          <div class="tarjetas-curso-asignatura oculto">
            <?php if (!empty($asignaturas[$curso])): ?>
              <?php foreach ($asignaturas[$curso] as $asignatura): ?>
                <div class="tarjeta-asignatura-alumno"
                  data-nombre="<?= strtolower($asignatura['nombre_asignatura']) ?>"
                  data-curso="<?= $curso ?>">
                  <h3 class="titulo-asignatura-alumno">
                    <?= htmlspecialchars($asignatura['nombre_asignatura']) ?>
                  </h3>
                  <ul class="detalles-asignatura-alumno">
                    <li>Prof. <?= htmlspecialchars($asignatura['nombre_profesor'] ?? 'Desconocido') ?></li>
                    
                  </ul>
                  <div class="pie-tarjeta-asignatura">
                    
                    <a href="asignatura_seleccionada_tareas_profesor.php?id=<?= $asignatura['ID_asignatura'] ?>" class="icono-ir-asignatura">➜</a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="mensaje-sin-asignaturas">No hay asignaturas para este curso.</p>
            <?php endif; ?>
          </div>

        </div>
      </section>
    <?php endforeach; ?>
  </div>

</body>

</html>