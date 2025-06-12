<?php
include('../api/conexion_bd_proa.php');

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
    $titulo         = $_POST['titulo'] ?? '';
    $descripcion    = $_POST['descripcion'] ?? '';
    $id_asignatura  = $_POST['ID_asignatura'] ?? 1;

    // Apertura
    $f_apertura = $_POST['fecha_apertura'] ?? '';
    $h_apertura = $_POST['hora_apertura'] ?? '';
    $fecha_publicacion = (!empty($f_apertura) && !empty($h_apertura)) ? "$f_apertura $h_apertura" : null;

    // Entrega
    $f_entrega = $_POST['fecha_entrega'] ?? '';
    $h_entrega = $_POST['hora_entrega'] ?? '';
    $fecha_entrega = (!empty($f_entrega) && !empty($h_entrega)) ? "$f_entrega $h_entrega" : null;

    // Manejo del archivo adjunto
    $href = $tarea['href'] ?? null;
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        $fileUpload = $_FILES['adjunto'];
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/api/adjuntos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $filename = basename($fileUpload["name"]);
        $target_file = $target_dir . $filename;

        if (file_exists($target_file)) {
            $error = 'El archivo ya existe.';
        } else {
            $sizeLimit = 1024 * 1024 * 5;
            if ($fileUpload["size"] > $sizeLimit) {
                $error = 'El archivo adjunto es demasiado grande (máx. 5 MB)';
            } else {
                if (!move_uploaded_file($fileUpload["tmp_name"], $target_file)) {
                    $error = 'No se pudo guardar el archivo';
                } else {
                    $href = "/api/adjuntos/" . $filename;
                }
            }
        }
    }

    if (!$error) {
        $stmt = $conex->prepare("UPDATE tareas SET titulo=?, descripcion=?, fecha_publicacion=?, fecha_entrega=?, ID_asignatura=?, href=? WHERE ID_tarea=?");
        $stmt->bind_param("ssssssi", $titulo, $descripcion, $fecha_publicacion, $fecha_entrega, $id_asignatura, $href, $id_tarea);
        if ($stmt->execute()) {
            header("Location: asignatura_seleccionada_tareas_profesor.php?id=$id_asignatura");
            exit;
        } else {
            $error = "Error al actualizar la tarea.";
        }
    }
}

// ...después de cargar $tarea y definir $id_asignatura...
$asignatura = '';
if ($tarea && isset($tarea['ID_asignatura'])) {
    $id_asignatura = $tarea['ID_asignatura'];
    $stmt2 = $conex->prepare("SELECT nombre FROM asignaturas WHERE ID_asignatura = ?");
    $stmt2->bind_param("i", $id_asignatura);
    $stmt2->execute();
    $stmt2->bind_result($nombre_asignatura);
    if ($stmt2->fetch()) {
        $asignatura = $nombre_asignatura;
    }   
    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PROA | Editar Tarea</title>
    <link rel="stylesheet" href="../app/css/estilos_combinados.css">
    <script src="../js/botonpublico.js" defer></script>
</head>

<body class="body-fondo">
    <?php include('encabezado_profesor.php'); ?>

    <nav class="migas_de_pan">
    <a href="./home_page_profesor.php">Inicio</a> &gt;
    <a href="./asignatura_seleccionada_profesor.php?id=<?= $id_asignatura ?>"><?= htmlspecialchars($asignatura) ?></a> &gt;
    <a href="./asignatura_seleccionada_tareas_profesor.php?id=<?= $id_asignatura ?>">Tareas</a> &gt;
    <span>Editar tarea</span>
</nav>
    <div class="titulo-asignatura">
        <h1>Editar Tarea <?= htmlspecialchars($tarea['titulo'] ?? '') ?></h1>
    </div>

    <main>
        <?php if ($error): ?>
            <div class="warnings" style="color:red; text-align:center; margin-bottom:1em;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif ($tarea): ?>
            <form class="form-crear-tarea" id="form" method="POST" enctype="multipart/form-data">
                <div class="form-interior">
                    <label for="titulo">Título de la tarea</label>
                    <input name="titulo" type="text" id="titulo" value="<?= htmlspecialchars($tarea['titulo']) ?>" required />
                </div>

                <div class="form-div-fecha">
                    <div class="form-interior">
                        <label for="fecha_apertura">Fecha apertura</label>
                        <input name="fecha_apertura" type="date" id="fecha_apertura" value="<?= htmlspecialchars(substr($tarea['fecha_publicacion'], 0, 10)) ?>" />
                    </div>
                    <div class="form-interior">
                        <label for="hora_apertura">Hora</label>
                        <input name="hora_apertura" type="time" id="hora_apertura" value="<?= htmlspecialchars(substr($tarea['fecha_publicacion'], 11, 5)) ?>" />
                    </div>

                    <div class="form-interior">
                        <label for="fecha_entrega">Fecha entrega</label>
                        <input name="fecha_entrega" type="date" id="fecha_entrega" value="<?= htmlspecialchars(substr($tarea['fecha_entrega'], 0, 10)) ?>" />
                    </div>
                    <div class="form-interior">
                        <label for="hora_entrega">Hora</label>
                        <input name="hora_entrega" type="time" id="hora_entrega" value="<?= htmlspecialchars(substr($tarea['fecha_entrega'], 11, 5)) ?>" />
                    </div>

                    <div class="form-interior">
                        <label for="adjunto">Archivo adjunto</label>
                        <input type="file" name="adjunto" id="adjunto">
                        <?php if (!empty($tarea['href'])): ?>
                            <div id="info-file">
                                Archivo actual: <a href="<?= htmlspecialchars($tarea['href']) ?>" target="_blank">Ver adjunto</a>
                            </div>
                        <?php else: ?>
                            <div id="info-file">Ningún archivo seleccionado</div>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="ID_asignatura" value="<?= htmlspecialchars($tarea['ID_asignatura']) ?>" />
                </div>

                <div class="form-interior">
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="6"><?= htmlspecialchars($tarea['descripcion']) ?></textarea>
                </div>

                <div class="botones-crear">
                    <div class="boton-guardar-form">
                        <input type="submit" class="guardar" name="cancelar" value="Cancelar" />
                    </div>
                    <div class="boton-guardar-form">
                        <input type="submit" class="guardar" name="guardar" value="Guardar" />
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
