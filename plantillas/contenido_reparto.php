<?php
$servername = "localhost";
$username = "root";
$password = "";
$tabla = "reparto";
$porPagina = 15;

// Página actual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;
$offset = ($pagina - 1) * $porPagina;

// Conexión
try {
    $conn = new PDO("mysql:host=$servername;dbname=primerejemplo", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Búsqueda (por GET ahora)
    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
    $metodo = isset($_GET['metodo']) ? $_GET['metodo'] : '';
    $hayBusqueda = !empty($busqueda);

    // 1. Contar total de resultados
    if ($hayBusqueda) {
        $sqlTotal = "SELECT COUNT(*) FROM $tabla WHERE $metodo LIKE :busqueda";
    } else {
        $sqlTotal = "SELECT COUNT(*) FROM $tabla";
    }

    $stmtTotal = $conn->prepare($sqlTotal);
    if ($hayBusqueda) {
        $stmtTotal->bindValue(':busqueda', '%' . $busqueda . '%');
    }
    $stmtTotal->execute();
    $totalResultados = $stmtTotal->fetchColumn();

    // 2. Obtener resultados paginados
    if ($hayBusqueda) {
        $sql = "SELECT texto, cod_mun, dia FROM $tabla WHERE $metodo LIKE :busqueda ORDER BY texto LIMIT :offset, :porPagina";
    } else {
        $sql = "SELECT texto, cod_mun, dia FROM $tabla ORDER BY texto LIMIT :offset, :porPagina";
    }

    $stmt = $conn->prepare($sql);
    if ($hayBusqueda) {
        $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':porPagina', $porPagina, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Mostrar formulario
    ?>
    <div class="busqueda">
        <h2 style="padding-bottom: 10px">Usuarios del sistema</h2>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="search" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
            <input type="radio" id="metodo_texto" name="metodo" value="texto">
                <label for="texto">texto</label><br>
            <input type="radio" id="metodo_cod" name="metodo" value="cod_mun">
                <label for="cod_mun">Código municipio</label><br>
            <input type="radio" id="metodo_dia" name="metodo" value="dia">
                <label for="dia">Dia reparto</label>
            <input type="submit" value="Buscar">
        </form>
    </div>
    <?php

    // 4. Mostrar tabla
    if (count($result) == 0) {
        echo "<h4>No se han encontrado localidades</h4>";
    } else {
        echo "<table id='tablaUsuarios'>";
        echo "<tr><th>Localidad</th><th>Codigo postal</th><th>Día reparto</th></tr>";
        foreach ($result as $fila) {
            echo "<tr><td>" . $fila['texto'] . "</td><td>" . $fila['cod_mun'] . "</td><td>" . $fila['dia'] . "</td></tr>";
        }
        echo "</table>";
    }

    // 5. Paginación (solo si hay más de 15 resultados)
    if ($totalResultados > $porPagina) {
        $totalPaginas = ceil($totalResultados / $porPagina);
        echo "<div class='paginacion' style='margin-top: 10px;'>";

        for ($i = 1; $i <= $totalPaginas; $i++) {
            $url = $_SERVER['PHP_SELF'] . "?pagina=$i";
if ($hayBusqueda) {
    $url .= "&busqueda=" . urlencode($busqueda);
    if (!empty($metodo)) {
        $url .= "&metodo=" . urlencode($metodo);
    }
}
            echo "<a href='$url'" . ($i == $pagina ? " style='font-weight:bold; text-decoration:underline;'" : "") . ">$i</a> ";
        }

        echo "</div>";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>

