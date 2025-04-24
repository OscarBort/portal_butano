<?php
include "plantillas/funciones.php";

inicioSesion();

if($_SESSION["rol"] != "administrador"){
    header("Location: index.php");
}
else{
include "plantillas/headerUsuario.php";
include "plantillas/menu.php";

// try {
//     $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     // Verificamos si es una solicitud POST y si el 'id' está presente
//     if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
//         // Limpiar y preparar datos del formulario
//         $usuario = trim($_POST['usuario']);
//         $rol = trim($_POST['rol']);
//         $email = trim($_POST['email']);
//         $email = $email === '' ? null : $email;
//         $nombre = trim($_POST['nombre']);
//         $nombre = $nombre === '' ? null : $nombre;

//         // Obtener los datos actuales de la base de datos para comparar
//         $id = $_POST['id']; // Usamos el ID de POST que viene del formulario

//         $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
//         $stmt->bindParam(':id', $id);
//         $stmt->execute();
//         $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

//     // Obtener los datos del usuario a editar desde GET
//     if (isset($_GET['id'])) {
//         $id = $_GET['id'];
//         $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
//         $stmt->bindParam(':id', $id);
//         $stmt->execute();
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     }

// } 

// if (isset($result)) {
//     // Mostrar formulario con los datos del usuario
//     echo "<table>
//     <tr><th>ID</th><td>" . $result['id'] . "</td></tr>
//     <tr><th>Usuario</th><td>" . $result['user'] . "</td></tr>
//     <tr><th>Contraseña</th><td>" . $result['password'] . "</td></tr>
//     <tr><th>Correo</th><td>" . $result['email'] . "</td></tr>
//     <tr><th>Nombre</th><td>" . $result['nombre'] . "</td></tr>
//     <tr><th>Rol</th><td>" . $result['rol'] . "</td></tr>
//     </table>";
// } 
// } catch(PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }
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
        $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "<table id=tablaUsuarios>
            <tr><th>ID</th><td>" . $result['id'] . "</td></tr>
            <tr><th>Usuario</th><td>" . $result['user'] . "</td></tr>
            <tr><th>Contraseña</th><td>" . $result['password'] . "</td></tr>
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
include "plantillas/footer.php";
}
?>