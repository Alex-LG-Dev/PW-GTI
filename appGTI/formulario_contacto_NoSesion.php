<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajax'])) {
    include('apigti/conexionbdgti.php');
    header('Content-Type: application/json');

    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    $producto = $_POST['producto'] ?? '';

    if (empty($nombre) || empty($email) || empty($motivo) || empty($producto)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO consultas_contacto (nombre, email, motivo, producto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $motivo, $producto);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Consulta enviada correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al enviar la consulta.']);
    }

    $stmt->close();
    $conexion->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>GTI | Contacto</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Formulario de contacto">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="cssGTI/estiloGTI.css">
</head>
<body>

<?php include('encabezado_NoSesion.php'); ?>

<main>
  <section class="seccion-contacto">
    <div class="banner-contacto">
      <h2>CONTÁCTANOS</h2>
    </div>
    <div class="banner-contacto2">
      <h3>Empecemos nuestro diálogo</h3>
      <p>¿Te interesa alguno de nuestros módulos? Rellena este simple formulario con tus datos y así resolveremos tus dudas.</p>
    </div>
    <div id="Formulario">
      <form id="form" class="form-contacto">
        <label for="nombreUsuario">Nombre y Apellidos</label>
        <input id="nombreUsuario" type="text" name="nombre" placeholder="Escribe tu nombre" required>

        <label for="email">Correo institucional</label>
        <input id="email" type="email" name="email" placeholder="Ej: correo@institucional" required>

        <label for="motivo">Motivo</label>
        <textarea id="motivo" name="motivo" placeholder="Escribe tu duda" required></textarea>

        <label for="productos">Producto</label>
        <select name="producto" id="productos" required>
          <option value="">Elija un Producto</option>
          <option value="Modulo Tareas">Módulo Tareas</option>
          <option value="Modulo Calendario">Módulo Calendario</option>
        </select>

        <button type="submit" class="botonGTI">Enviar</button>
        <p class="warnings" id="warnings"></p>
      </form>
    </div>
  </section>
</main>

<script>
document.getElementById('form').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita la recarga

    const formData = new FormData(this);
    formData.append('ajax', '1'); 

    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            document.getElementById('form').reset();
        }
    })
    .catch(err => {
        console.error('Error en la consulta:', err);
        alert('Error al enviar la consulta.');
    });
});
</script>

</body>
</html>
