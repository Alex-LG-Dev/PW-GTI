<?php
require_once __DIR__ . '/lib/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/lib/PHPMailer/SMTP.php';
require_once __DIR__ . '/lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$nombre = $_POST['nombreUsuario'] ?? '';
$email = $_POST['email'] ?? '';
$contraseña = $_POST['contraseña'] ?? '';

function enviarCorreoRegistro($nombre, $email) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.ethereal.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'victoria71@ethereal.email';
        $mail->Password = 'QnDFTjV65s33mDUpfF';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('victoria7j@ethereal.email', 'GTI Soporte');
        $mail->addAddress($email, 'hola');

        $mail->isHTML(true);
        $mail->Subject = 'Bienvenido a GTI';
        $mail->Body = "<h3>Hola $nombre,</h3><p>Gracias por registrarte en GTI!</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar el correo: " . $mail->ErrorInfo);
        return false;
    }
}
if (enviarCorreoRegistro($nombre, $email)) {
    header("Location: ../index.php");
    exit();
} else {
    echo "Error al enviar el correo.";
}