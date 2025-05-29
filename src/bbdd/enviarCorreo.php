<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../app/lib/PHPMailer/Exception.php';
require_once '../app/lib/PHPMailer/PHPMailer.php';
require_once '../app/lib/PHPMailer/SMTP.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("conexionbasesPROA.php");

    $nombre = trim($_POST['nombreUsuario']);
    $email = trim(strtolower($_POST['email']));
    $password = trim($_POST['contraseña']);

    if (empty($nombre) || empty($email) || empty($password)) {
        die("Todos los campos son obligatorios.");
    }

    // Verificar si ya existe el email
    $check = $conexion->prepare("SELECT id FROM usuarios_registrados WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("El email ya está registrado.");
    }

    // Crear token y hashear contraseña
    $token = bin2hex(random_bytes(16));
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Guardar usuario
    $stmt = $conexion->prepare(
        "INSERT INTO usuarios_registrados (nombre, email, contrasena, estado, token, validez_token) 
         VALUES (?, ?, ?, 'pendiente', ?, NULL)"
    );
    $stmt->bind_param("ssss", $nombre, $email, $hash, $token);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);

        try {
            // ✔️ Configurar SMTP correctamente
            $mail->isSMTP(); // <--- IMPORTANTE
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'modulosgti@gmail.com';           // Tu correo Gmail
            $mail->Password   = 'vtui hxwn uewh yhyk';            // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // ✔️ Dirección del remitente y destinatario
            $mail->setFrom('modulosgti@gmail.com', 'GTI');
            $mail->addAddress($email, $nombre);

            // ✔️ Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu cuenta en GTI';
            $mail->Body    = "
                <h3>Hola, $nombre</h3>
                <p>Gracias por registrarte. Haz clic en el siguiente enlace para verificar tu cuenta:</p>
                <a href='http://localhost:3000/verificar.php?token=$token'>Verificar mi cuenta</a>
                <br><br>
                <p>Si no solicitaste esta cuenta, puedes ignorar este correo.</p>
            ";

            $mail->send();
            echo "✅ Registro exitoso. Revisa tu correo para verificar la cuenta.";
        } catch (Exception $e) {
            echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ Error al registrar el usuario.";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso denegado.";
}
