<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {  #aqui pondreis lo que vosotros querais capturar
    // Capturar y sanitizar los datos del formulario
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $correo = isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '';
    $telefono = isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '';
    $comentario = isset($_POST['comentario']) ? htmlspecialchars($_POST['comentario']) : '';
    $pedido = isset($_POST['pedido']) ? htmlspecialchars($_POST['pedido']) : '';

    // Validar campos obligatorios
    /*if (empty($nombre) || empty($dni) || empty($email)) {
        die("Los campos obligatorios (Nombre, DNI, Correo) son requeridos.");
    }*/

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP de Mailtrap
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '13e6fa5d852f36'; // Reemplaza con tu username de Mailtrap
        $mail->Password = 'd09746d18a4e45'; // Reemplaza con tu password de Mailtrap
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        $mail->CharSet = 'UTF-8'; // Asegura que los caracteres especiales se codifiquen correctamente

        // Configurar remitente y destinatario
        $mail->setFrom('no-reply@ejemplo.com', 'Butano');#aqui iria el monbre de vuestro porta
        $mail->addAddress('destinatario@ejemplo.com'); // Capturado por Mailtrap

        // Contenido del correo con datos del formulario /*aqui pondiais vuestros datos que quereis que recoja*/
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo pedido de ' . $nombre;
        $mail->Body = "
            <h1>Nuevo pedido</h1>
            <p><strong>Nombre completo:</strong> $nombre</p>
            <p><strong>Correo electrónico:</strong> $correo</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Pedido:</strong> " . nl2br($pedido) . "</p>
            <p><strong>Comentarios:</strong> " . nl2br($comentario) . "</p>
        ";
        $mail->AltBody = "Nombre: $nombre\n\nCorreo: $correo\nTeléfono: $telefono\nPedido: $pedido\nComentario: $comentario"; #esto es el mensaje segun los campos que tengas en tu formulario 

        // Enviar correo
        $mail->send();
        // Redirigir al formulario con mensaje de éxito
        header("Location: index.php?success=1");
        exit;
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "Por favor, envía el formulario.";
}
?>