
<?php
echo "Conexión exitosa a la base de datos.";
include("conexionbasesPROA.php");
const HOST_URL= 'http://localhost';

function procesarAdjunto(){
    global $conex;

    // Solo procesar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return 'No se ha enviado el formulario.';

    // Recoger datos del formulario
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $publicada = $_POST['publicada'] ?? 'No';
    $id_asignatura = $_POST['ID_asignatura'] ?? 1;

    // Validar campos obligatorios
    if (empty($titulo) || empty($fecha) || empty($hora)) {
        return '⚠️ Por favor completa todos los campos requeridos.';
    }

    // Combinar fecha y hora
    $fecha_entrega = $fecha . ' ' . $hora;

    // Procesar archivo adjunto si existe
    $href = null;
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        $fileUpload = $_FILES['adjunto'];
        $target_dir = "../bbdd/adjuntos/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . basename($fileUpload["name"]);

        if (file_exists($target_file)) return 'El archivo ya existe';
        $sizeLimit = 1024 * 1024 * 5;
        if ($fileUpload["size"] > $sizeLimit) return 'El archivo adjunto es demasiado grande (max 5 MB)';

        if (!move_uploaded_file($fileUpload["tmp_name"], $target_file)) return 'No se pudo guardar el archivo';

        $href = HOST_URL . '/bbdd/adjuntos/' . basename($fileUpload["name"]);
    }

    // Preparar consulta: fecha_publicacion se genera con NOW()
    $query = "INSERT INTO tareas (titulo, publicada, descripcion, fecha_publicacion, fecha_entrega, ID_asignatura, href) 
              VALUES (?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conex->prepare($query);
    if (!$stmt) return "Error en la preparación de la consulta: " . $conex->error;

    $stmt->bind_param("ssssis", $titulo, $publicada, $descripcion, $fecha_entrega, $id_asignatura, $href);

    if ($stmt->execute()) {
        return "✅ Tarea creada correctamente.";
    } else {
        return "❌ Error al guardar la tarea: " . $stmt->error;
    }
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Tarea</title>
    <link rel="stylesheet" href="../app/css/estilos_combinados.css">
</head>
<body>
<div><?php echo procesarAdjunto()?></div>
</body>
</html>