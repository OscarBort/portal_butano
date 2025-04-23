<?php
if (!isset($_SESSION["rol"]))
$_SESSION["rol"] = "invitado";
?>
<nav>
        <ul>
            <li id="inicio"><a href="index.php">Inicio</a></li>
            <li><a href="">Productos</a></li>
            <li><a href="">Pedidos</a></li>
            <?php
            if ($_SESSION["rol"] == "administrador"){
            echo '<li><a href="usuarios.php">Usuarios</a></li>';
            echo '<li><a href="editarDatos.php">Editar</a></li>';
            }
            ?>
            <li><a href="">Fecha reparto</a></li>
            <li id="contacto"><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>
    <main>