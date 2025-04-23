<?php
include "plantillas/funciones.php";

inicioSesion();

    if ($_SESSION["rol"] == "invitado"){
        include "plantillas/headerInvitado.php";
        include "plantillas/menu.php";
        include "plantillas/contenido_contacto.php";
        include "plantillas/footer.php";
    }
    else{
        include "plantillas/headerUsuario.php";
        include "plantillas/menu.php";
        include "plantillas/contenido_contacto.php";
        include "plantillas/footer.php";
    }
?>