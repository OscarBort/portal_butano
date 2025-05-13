<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {  #aqui pondreis lo que vosotros querais capturar
    // Capturar y sanitizar los datos del formulario
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '';

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

        // Configurar remitente y destinatario
        $mail->setFrom('no-reply@ejemplo.com', 'Cimientos & Sueños');#aqui iria el monbre de vuestro porta
        $mail->addAddress('destinatario@ejemplo.com'); // Capturado por Mailtrap

        // Contenido del correo con datos del formulario /*aqui pondiais vuestros datos que quereis que recoja*/
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo pedido de ' . $nombre;
        $mail->Body = "
            <h1>Nuevo pedido</h1>
            <p><strong>Nombre completo:</strong> $nombre</p>
            <p><strong>Correo electrónico:</strong> $email</p>
            <p><strong>Mensaje:</strong> $mensaje</p>
        ";
        $mail->AltBody = "Nombre: $nombre\nDNI: $dni\nCorreo: $email\nTeléfono: $telefono\nTipo: $tipo\nPresupuesto: $presupuesto\nMensaje: $mensaje"; #esto es el mensaje segun los campos que tengas en tu formulario 

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