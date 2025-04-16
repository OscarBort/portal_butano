<?php
    session_start();
    //session_regenerate_id(true);

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";

    var_dump($_SESSION);

    if ($_SESSION["rol"] == "invitado"){
        include "plantillas/headerInvitado.php";
        include "plantillas/menu.php";
        include "plantillas/contenidoMain.php";
        include "plantillas/footer.php";
    }
    else {
        include "plantillas/headerUsuario.php";
        include "plantillas/menu.php";
        include "plantillas/contenidoMain.php";
        include "plantillas/footer.php";
    }
?>