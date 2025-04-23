<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {

        $email = empty($_POST['email']) ? null : $_POST['email'];
        $nombre = empty($_POST['nombre']) ? null : $_POST['nombre'];
        // Actualizar los datos
        $sql = "UPDATE usuarios SET 
                    user = :usuario,
                    password = :password,
                    email = :email,
                    nombre = :nombre,
                    rol = :rol
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $_POST['usuario']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->bindValue(':email', $email, $email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':nombre', $nombre, $nombre === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':rol', $_POST['rol']);
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();

        echo "Datos actualizados correctamente.<br><br>";
    }

    // Obtener datos actuales para el formulario
    $stmt = $conn->prepare("SELECT id, user, password, email, nombre, rol FROM usuarios WHERE user = :user");
    $stmt->bindParam(':user', $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($result) {
    echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>
        <input type='hidden' id='idDatos' name='id' value='{$result['id']}' readonly><br>
        <label for='usuario'>Nick: </label><input type='text' id='usuarioDatos' name='usuario' value='{$result['user']}'><br>
        <label for='password'>Contraseña: </label><input type='text' id='passwordDatos' name='password' value='{$result['password']}'><br>
        <label for='email'>Correo: </label><input type='email' id='emailDatos' name='email' value='{$result['email']}'><br>
        <label for='nombre'>Nombre: </label><input type='text' id='nombreDatos' name='nombre' value='{$result['nombre']}'><br>
        <label for='rol'>Rol: </label><input type='text' id='rolDatos' name='rol' value='{$result['rol']}'>
        <input type='submit' value='Enviar'></form>";
}

$conn = null;
?>