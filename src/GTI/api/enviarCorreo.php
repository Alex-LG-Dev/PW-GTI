<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// librerias de phpmailer
require_once '../app/lib/PHPMailer/Exception.php';
require_once '../app/lib/PHPMailer/PHPMailer.php';
require_once '../app/lib/PHPMailer/SMTP.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
// se aprieta el boton
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("conexionbdgti.php");

    $nombre = trim($_POST['nombreUsuario']);
    $email = trim(strtolower($_POST['email']));
    $password1 = trim($_POST['contraseña1']);
    $password2 = trim($_POST['contraseña2']);

    if (empty($nombre) || empty($email) || empty($password1) || empty($password2)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    if ($password1 !== $password2) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    $password = $password1; // $password es la contraseña validada


    // Verificar si ya existe el email
    $check = $conexion->prepare("SELECT id FROM usuarios_registrados WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('El email ya está registrado.'); window.history.back();</script>";
        exit;
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
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'modulosgti@gmail.com';
            $mail->Password   = 'vtui hxwn uewh yhyk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('modulosgti@gmail.com', 'GTI');
            $mail->addAddress($email, $nombre);

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

            echo "<script>alert('Registro exitoso. Revisa tu correo para verificar la cuenta.'); window.location.href = '../../login.php';</script>";
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Error al enviar el correo. Intenta más tarde.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "<script>alert('Acceso denegado.'); window.location.href = '../login.php';</script>";
    exit;
}
