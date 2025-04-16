<?php include "funciones.php"; ?>
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
</head>
<?php
    if(isset($_POST["usuario"]) && isset($_POST["password"])){
        //if ($_SERVER["PHP_SELF"] != "/portal/login.php")
            //$_SESSION['origen'] = $_SERVER["PHP_SELF"];
        login(sanear($_POST["usuario"]), sanear($_POST["password"]));
    }
?>
<body>
    <header>
        <div id="headIzquierda">
            <img src="img/logo.png" alt="Bombona de butano naranja de las de toda la vida." id="logo">
        </div>
        <div id="headCentro">
            <h1>Distibuidora de gas ifcd</h1>
        </div>
        <div id="headDerecha">
            <!-- <form method="post" action="login.php"> -->
            <form method="post" action="<?=($_SERVER['PHP_SELF'])?>">
                <label for="usuario">Usuario:</label><br>
                <input type="text" id="usuario" name="usuario" autocomplete="off"><br>
                <label for="password">Last name:</label><br>
                <input type="password" id="password" name="password" autocomplete="off"><br>
                <input type="submit" value="Submit" id="boton"><button type="button" id="registro">Registro</button>
            </form>
            <div id="errorSesion">
                <?php
                    if (isset($_SESSION['mensaje'])) {
                        echo $_SESSION['mensaje'];
                        unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
                    }
                ?>
            </div>
        </div>   
    </header>