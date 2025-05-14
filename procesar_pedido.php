<?php

include "plantillas/funciones.php";

    inicioSesion();

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";
    
    if ($_SESSION["rol"] != "invitado"){
        include "plantillas/headerUsuario.php";
        include "plantillas/menu.php";

        echo '<form action="enviar_correo.php" method="POST">
            <label for="nombre">Nombre:</label><input type="text" id="nombrePedido" name="nombre">
            <label for="correo">Correo elecrtónico:</label><input type="email" id="correoPedido" name="correo">
            <label for="telefono">Teléfono:</label><input type="tel" id="telefonoPedido" name="telefono" pattern="[0-9]{9}">
            <label for="comentario">Comentarios:</label><input type="textarea" id="comentarioPedido" name="comentario" rows="10" cols="50">
            <textarea id="datosPedido" name="pedido" rows="10" cols="50">' . 
                (isset($_POST['pedidoResumen']) ? ($_POST['pedidoResumen']) : '') . 
                '</textarea>
            <input type="submit">
            </form>';

        include "plantillas/footer.php";
    }
    else{
        include "plantillas/headerInvitado.php";
        include "plantillas/menu.php";
        include "plantillas/usuarioError.php";
        include "plantillas/footer.php";
    }


?>