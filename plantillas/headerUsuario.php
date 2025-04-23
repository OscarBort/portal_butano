<?php
date_default_timezone_set("Europe/Madrid");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/89d2629216.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img/favicon.png">
    <title>Primer Portal</title>
    <script>
function miFuncion() {
window.location.href = "plantillas/logout.php";
}
</script>
</head>
<body>
    <header>
        <div id="headIzquierda">
            <img src="img/logo.png" alt="Bombona de butano naranja de las de toda la vida." id="logo">
        </div>
        <div id="headCentro">
            <h1>Distibuidora de gas ifcd</h1>
        </div>
        <div id="headDerecha">
            <p>Hola <?php echo $_SESSION["user"]?>.</p>
            <p id="hora">Son las <?php echo date("H:i:s")?>.</p>
            <div id="logout"><?php echo "<a href='" . $_SERVER['PHP_SELF'] . "?salir'>Logout</a>"?></div>
        </div>
    </header>