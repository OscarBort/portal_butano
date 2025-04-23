<?php
    session_start();

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";
    
    if ($_SESSION["rol"] == "administrador"){
        include "plantillas/headerUsuario.php";
        include "plantillas/menu.php";
        include "plantillas/contenido_Usuario.php";
        include "plantillas/footer.php";
    }
    else{
        include "plantillas/headerInvitado.php";
        include "plantillas/menu.php";
        include "plantillas/usuarioError.php";
        include "plantillas/footer.php";
    }
?>
