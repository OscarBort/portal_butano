<?php
// Inicializamos variables
$nombre = $correo = $mensaje = "";
$errores = [];

// Si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar datos
    $nombre = sanear($_POST["nombre"]);
    $correo = sanear($_POST["correo"]);
    $mensaje = sanear($_POST["message"]);

    // Validar nombre (solo letras y tildes, 3-15 caracteres)
    if (!preg_match('/^[A-Za-zÑñÁáÉéÍíÓóÚú]{3,15}$/', $nombre)) {
        $errores[] = "El nombre debe tener entre 3 y 15 letras sin espacios ni números.";
    }

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    // Validar mensaje (no vacío)
    if (empty($mensaje)) {
        $errores[] = "El mensaje no puede estar vacío.";
    }

    // Si no hay errores, procesamos el formulario
    if (empty($errores)) {
        echo "<p>Formulario enviado correctamente.</p>";
        // Aquí podrías guardar en BD, enviar un mail, etc.
        // Limpiar campos para que no se rellenen de nuevo
        $nombre = $correo = $mensaje = "";
    }
}
?>

<script>
    document.getElementById("contacto")?.classList.add("activo");
</script>

<form id="contactoForm" method="post" action="">
    <fieldset>
        <legend>Contacto</legend>

        <?php
        if (!empty($errores)) {
            echo "<ul style='color:red;'>";
            foreach ($errores as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
        ?>

        <label id="nombreL" for="nombre">Usuario: </label>
        <input type="text" id="nombre" name="nombre" autocomplete="off" value="<?php echo htmlspecialchars($nombre); ?>"><br>

        <label id="correoL" for="correo">Correo: </label>
        <input type="email" id="correo" name="correo" autocomplete="off" value="<?php echo htmlspecialchars($correo); ?>"><br>

        <textarea id="textArea" name="message" style="width:300px; height:100px;" autocomplete="off"><?php echo htmlspecialchars($mensaje); ?></textarea><br>

        <input type="submit" value="Enviar" id="botonForm">
    </fieldset>
</form>

