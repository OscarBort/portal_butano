<?php
include "plantillas/funciones.php";

inicioSesion();

include "plantillas/headerUsuario.php";
include "plantillas/menu.php";

// Vamos a pintar el formulario para crear nuevos usuarios

echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
      <label for='usuario'>Usuario: </label><input type='text' id='crearUsuario' name='usuario' autocomplete='off' autofocus><br>
      <label for='password'>Contraseña: </label><input type='text' id='crearPassword' name='password' autocomplete='off'><br>
      <label for='email'>Correo: </label><input type='email' id='crearEmail' name='email' autocomplete='off'><br>
      <label for='nombre'> Nombre: </label><input type='text' id='crearNombre' name='nombre' autocomplete='off'><br>
      <label for='estado'> Estado usuario: </label><select id='crearEstado' name='estado'>
        <option value='activo'>Activo</option>
        <option value='inactivo'>Inactivo</option>
        <option value='suspendido'>Suspendido</option></select><br>
      <label for='rol'>Rol: </label><select id='crearRol' name='rol'>
        <option value='administrador'>Administrador</option>
        <option value='usuario'>Usuario</option></select>
      <input type='submit' value='Enviar'>
      </form>";

$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=primerejemplo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    if (isset($_POST['usuario'], $_POST['password'], $_POST['email'], $_POST['nombre'], $_POST['estado'], $_POST['rol'])){
      $user = sanear($_POST['usuario']);
      $password = password_hash(sanear($_POST['password']), PASSWORD_DEFAULT);
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $nombre = $_POST['nombre'];
      $estado = $_POST['estado'];
      $rol = $_POST['rol'];
    } else {
      if ($_SERVER['REQUEST_METHOD'] === 'POST'){
      echo "Faltan datos en el formulario.";
      }
      exit;
      }
  

    $sql = "INSERT INTO usuarios (user, password, email, nombre, estado, rol)
            VALUES ('$user', '$password', '$email', '$nombre', '$estado', '$rol')";
    // use exec() because no results are returned
  $conn->exec($sql);
  header("Location: usuarios.php");
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
} $conn = null;

include "plantillas/footer.php";
?>