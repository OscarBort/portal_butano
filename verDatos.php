<?php
include "plantillas/funciones.php";

inicioSesion();

if($_SESSION["rol"] == "invitado"){
    header("Location: index.php");
}
else{
include "plantillas/headerUsuario.php";
include "plantillas/menu.php";

if($_SESSION["rol"] == "administrador"){
try {
    $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si se envió un formulario POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        $usuario = trim($_POST['usuario']);
        $rol = trim($_POST['rol']);
        $email = trim($_POST['email']) ?: null;
        $nombre = trim($_POST['nombre']) ?: null;

        $id = $_POST['id'];

        $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Si se quiere ver el detalle del usuario por GET
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT id, user, email, nombre, rol FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "<table id=tablaUsuarios>
            <tr><th>ID</th><td>" . $result['id'] . "</td></tr>
            <tr><th>Usuario</th><td>" . $result['user'] . "</td></tr>
            <tr><th>Correo</th><td>" . $result['email'] . "</td></tr>
            <tr><th>Nombre</th><td>" . $result['nombre'] . "</td></tr>
            <tr><th>Rol</th><td>" . $result['rol'] . "</td></tr>
            </table>";
        } else {
            echo "No se encontró el usuario.";
        }
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
} elseif ($_SESSION["rol"] == "usuario"){
    try {
        $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id, user, email, nombre, rol FROM usuarios WHERE user = :user");
        $stmt->bindParam(':user', $_SESSION["user"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // // Si se quiere ver el detalle del usuario por GET
        // if (isset($_GET['id'])) {
        //     $id = $_GET['id'];
        //     $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
        //     $stmt->bindParam(':id', $id);
        //     $stmt->execute();
            //$result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                echo "<table id=tablaUsuarios>
                <tr><th>ID</th><td>" . $result['id'] . "</td></tr>
                <tr><th>Usuario</th><td>" . $result['user'] . "</td></tr>
                <tr><th>Correo</th><td>" . $result['email'] . "</td></tr>
                <tr><th>Nombre</th><td>" . $result['nombre'] . "</td></tr>
                <tr><th>Rol</th><td>" . $result['rol'] . "</td></tr>
                </table>";
            }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        } 
        $conn = null;
    }
    
}

include "plantillas/footer.php";
?>