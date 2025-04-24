<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $tabla = "";
    if ($_SESSION['rol'] == 'administrador') {
        $sql = "";
        ?><div class="busqueda">
            <h2 style="padding-bottom: 10px">Usuarios del sistema</h2>

            <!-- Formulario de búsqueda -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?buscar">
                <input type="search" id="busqueda" name="busqueda">
                <input type="submit" value="Buscar">
            </form>

        </div>
    <?php    
        if (isset($_GET['buscar'])) {
            $sql = "SELECT id, user, email, facceso FROM usuarios WHERE user LIKE '%" . $_POST['busqueda'] . "%'";
        } else {
            $sql = "SELECT id, user, email, facceso FROM usuarios";
        }
    try {
        $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Aquí asignamos a $result el array que devuelve, si hay varias lineas tenemos que usar fetchAll.
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
  
        if (count($result) == 0) {
            $tabla = "<h4>No se han encontrado usuarios</h4>";
        } else {
            $tabla = "<table id='tablaUsuarios'>";
            $tabla .= "<tr><th>ID</th><th>Usuario</th><th>Email</th><th>Último acceso</th><th>Opciones</th></tr>";

            for ($i = 0; $i < count($result); $i++) {
                $tabla .= "<tr><td>";
                $tabla .= $result[$i]['id'];
                $tabla .= "</td><td>";
                $tabla .= $result[$i]['user'];
                $tabla .= "</td><td>";
                $tabla .= $result[$i]['email'];
                $tabla .= "</td><td>";
                $tabla .= $result[$i]['facceso'];
                $tabla .= "</td><td>";
                $tabla .= '<a class="iconitos" href=verDatos.php?ver&id=' . $result[$i]['id'] . '><span><i class="fa-solid fa-eye"></i></span></a>';
                $tabla .= '<a class="iconitos" href="editarDatos.php?editar&id=' . $result[$i]['id'] . '"><span><i class="fa-solid fa-pen"></i></span></a>';
                $tabla .= '<a class="iconitos" href=' . $_SERVER['PHP_SELF'] . '?borrar&id=' . $result[$i]['id'] . '><span><i class="fa-solid fa-trash"></i></span>';
                $tabla .= "</span></td></tr>";
            }
            $tabla .= "</table>";    
        }
        //Tabla de usuarios en BD
        echo $tabla;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;  
}
?>