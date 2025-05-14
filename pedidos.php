<?php
include "plantillas/funciones.php";

    inicioSesion();

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";
    
    if ($_SESSION["rol"] != "invitado"){
        include "plantillas/headerUsuario.php";
        include "plantillas/menu.php";
        include "plantillas/contenido_pedidos.php";
        include "plantillas/footer.php";
    }
    else{
        include "plantillas/headerInvitado.php";
        include "plantillas/menu.php";
        include "plantillas/usuarioError.php";
        include "plantillas/footer.php";
    }
?>