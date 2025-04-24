<?php
include "plantillas/funciones.php";

inicioSesion();

include "plantillas/headerUsuario.php";
include "plantillas/menu.php";

$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=primerejemplo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = sanear($_POST['usuario']);
    $password = sanear($_POST['password']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];
    $rol = $_POST['rol'];
    }

    $sql = "INSERT INTO usuarios (user, password, email, nombre, estado, rol)
            VALUES ($user, $password, $email, $nombre, $estado, $rol)";
    // use exec() because no results are returned
  $conn->exec($sql);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
} $conn = null;

include "plantillas/footer.php";
?>