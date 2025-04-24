<?php
include "plantillas/funciones.php";

inicioSesion();

if($_SESSION["rol"] != "administrador"){
    header("Location: index.php");
}
else{
include "plantillas/headerUsuario.php";
include "plantillas/menu.php";

try {
    $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificamos si es una solicitud POST y si el 'id' está presente
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
        // Limpiar y preparar datos del formulario
        $usuario = trim($_POST['usuario']);
        $rol = trim($_POST['rol']);
        $email = trim($_POST['email']);
        $email = $email === '' ? null : $email;
        $nombre = trim($_POST['nombre']);
        $nombre = $nombre === '' ? null : $nombre;

        // Obtener los datos actuales de la base de datos para comparar
        $id = $_POST['id']; // Usamos el ID de POST que viene del formulario

        $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comprobar si el usuario escribió una nueva contraseña
        $nuevaPassword = $_POST['password'];
        $cambioPassword = !empty($nuevaPassword);

        // Si escribió una nueva, la encriptamos. Si no, usamos la que ya había.
        $passwordHash = $cambioPassword ? password_hash($nuevaPassword, PASSWORD_DEFAULT) : $currentData['password'];

        // Verificar si hay cambios en cualquier campo
        $hayCambios = 
            $currentData['user'] !== $usuario ||
            $currentData['email'] !== $email ||
            $currentData['nombre'] !== $nombre ||
            $currentData['rol'] !== $rol ||
            $cambioPassword;

        if ($hayCambios) {
            $sql = "UPDATE usuarios SET 
                        user = :usuario,
                        password = :password,
                        email = :email,
                        nombre = :nombre,
                        rol = :rol
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindValue(':email', $email, $email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $nombre, $nombre === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':id', $_POST['id']);
            $stmt->execute();

            echo "Datos actualizados correctamente.<br><br>";
        } else {
            echo "No se detectaron cambios, no se actualizó nada.<br><br>";
        }
    }

    // Obtener los datos del usuario a editar desde GET
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($result)) {
    // Mostrar formulario con los datos del usuario
    echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>
        <input type='hidden' id='idDatos' name='id' value='{$result['id']}' readonly><br>
        <label for='usuario' class='labelEditar'>Nick: </label><input class='inputEditar' type='text' id='usuarioDatos' name='usuario' value='{$result['user']}'><br>
        <label for='password' class='labelEditar'>Cambiar contraseña: </label><input class='inputEditar' type='text' id='passwordDatos' name='password' value=''><br>
        <label for='email' class='labelEditar'>Correo: </label><input class='inputEditar' type='email' id='emailDatos' name='email' value='{$result['email']}'><br>
        <label for='nombre' class='labelEditar'>Nombre: </label><input class='inputEditar' type='text' id='nombreDatos' name='nombre' value='{$result['nombre']}'><br>
        <label for='rol' class='labelEditar'>Rol: </label><select id='rolDatos' name='rol'>
            <option value='administrador'>Administrador</option>
            <option value='usuario'>Usuario</option>
        <input type='submit' value='Enviar'>
    </form>";
}

$conn = null;
include "plantillas/footer.php";
}
?>