<?php
include('../bbdd/conexionbasesPROA.php');

$id_tarea = $_GET['id'] ?? null;
$tarea = null;
$error = '';

if ($id_tarea) {
    $stmt = $conex->prepare("SELECT * FROM tareas WHERE ID_tarea = ?");
    $stmt->bind_param("i", $id_tarea);
    $stmt->execute();
    $result = $stmt->get_result();
    $tarea = $result->fetch_assoc();
    if (!$tarea) {
        $error = "Tarea no encontrada.";
    }
} else {
    $error = "ID de tarea no especificado.";
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_tarea) {
    $titulo = $_POST['titulo'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_entrega = (!empty($fecha) && !empty($hora)) ? ($fecha . ' ' . $hora) : null;
    $id_asignatura = $_POST['ID_asignatura'] ?? 1;

    // Manejo del archivo adjunto
    $href = $tarea['href'] ?? null;
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        $fileUpload = $_FILES['adjunto'];
        // Usa la ruta absoluta basada en la raíz del servidor
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/bbdd/adjuntos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . basename($fileUpload["name"]);
        if (file_exists($target_file)) {
            $error = 'El archivo ya existe';
        } else {
            $sizeLimit = 1024 * 1024 * 5;
            if ($fileUpload["size"] > $sizeLimit) {
                $error = 'El archivo adjunto es demasiado grande (max 5 MB)';
            } else {
                if (!move_uploaded_file($fileUpload["tmp_name"], $target_file)) {
                    $error = 'No se pudo guardar el archivo';
                } else {
                    // El href debe ser solo la ruta relativa accesible desde la web
                    $href = "/bbdd/adjuntos/" . basename($fileUpload["name"]);
                }
            }
        }
    }

    if (!$error) {
        $stmt = $conex->prepare("UPDATE tareas SET titulo=?, descripcion=?, fecha_entrega=?, ID_asignatura=?, href=? WHERE ID_tarea=?");
        $stmt->bind_param("sssssi", $titulo, $descripcion, $fecha_entrega, $id_asignatura, $href, $id_tarea);
        if ($stmt->execute()) {
            header("Location: Asignatura_Seleccionada_tareas_Profesor.php");
            exit;
        } else {
            $error = "Error al actualizar la tarea.";
        }
    }
}
?>
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
    <title>PROA | Editar Tarea</title>
</head>
<body>
<?php include('encabezadoPROAprofesor.php'); ?>

<nav class="migas-de-pan">
  <p><a href="home-page-profesor.php">Inicio</a> &gt; Matemáticas</p>
</nav>
<div class="titulo-asignatura">
    <h1>Editar Tarea Matematicas</h1>
</div>
<main>
<?php if ($error): ?>
    <div class="warnings" style="color:red; text-align:center; margin-bottom:1em;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php elseif ($tarea): ?>
    <form class="form-crear-tarea" id="form" method="POST" enctype="multipart/form-data">
      <div class="form-interior">
        <label for="titulo">Título de la tarea</label>
        <input name="titulo" type="text" id="titulo" value="<?php echo htmlspecialchars($tarea['titulo']); ?>" required />
      </div>
      <div class="form-div-fecha">
        <div class="form-interior">
          <label for="fecha">Fecha entrega</label>
          <input name="fecha" type="date" id="fecha" value="<?php echo htmlspecialchars(substr($tarea['fecha_entrega'],0,10)); ?>" />
        </div>
        <div class="form-interior">
            <label for="hora">Hora</label>
            <input name="hora" type="time" id="hora" value="<?php echo htmlspecialchars(substr($tarea['fecha_entrega'],11,5)); ?>" />
        </div>
        <input type="file" name="adjunto" id="adjunto">
        <?php if (!empty($tarea['href'])): ?>
            <div id="info-file">
                Archivo actual: <a href="<?php echo htmlspecialchars($tarea['href']); ?>" target="_blank">Ver adjunto</a>
            </div>
        <?php else: ?>
            <div id="info-file">Ningún archivo seleccionado</div>
        <?php endif; ?>
        <input type="hidden" name="ID_asignatura" value="<?php echo htmlspecialchars($tarea['ID_asignatura']); ?>" />
      </div>
      <div class="form-interior">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="6"><?php echo htmlspecialchars($tarea['descripcion']); ?></textarea>
      </div>
      <div class="boton-guardar-form">
        <button type="submit" class="guardar">Guardar</button>
      </div>
    </form>
<?php endif; ?>
</main>
</body>
</html>
