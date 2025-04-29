<?php
include "plantillas/funciones.php";

inicioSesion();

if($_SESSION["rol"] != "administrador"){
    header("Location: index.php");
}
else{
include "plantillas/headerUsuario.php";
include "plantillas/menu.php";


// Mostrar confirmación
if (isset($_GET["id"]) && !isset($_POST["confirmar"])) {
    $id = (int) $_GET["id"];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el nombre de usuario
        $stmt = $conn->prepare("SELECT user FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $usuario = htmlspecialchars($result['user']);
            echo "<h2 id='confirmarBorrado'>¿Estás seguro de que deseas eliminar al usuario <strong>$usuario</strong>?</h2>";
            echo "<form method='POST' action=''>
                    <input type='hidden' name='id' value='$id'>
                    <button type='submit' name='confirmar' value='si' class='botonBorrado' id='siBorrado'>Sí</button>
                    <button type='submit' name='confirmar' value='no' class='botonBorrado'>No</button>
                  </form>";
        } else {
            echo "<p>Usuario no encontrado.</p>";
        }

        $conn = null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Procesar confirmación
if (isset($_POST["confirmar"])) {
    if ($_POST["confirmar"] === "no") {
        header("Location: usuarios.php");
        exit;
    }

    $id = (int) $_POST["id"];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Borrar el usuario
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<h2>Usuario eliminado correctamente.</h2>";
        echo "<p>Serás redirigido en 3 segundos...</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'usuarios.php';
                }, 3000);
              </script>";

        $conn = null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
}
include "plantillas/footer.php";
?>