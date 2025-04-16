<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    try {
        $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT user, email, nombre, rol, facceso, fcreacion FROM usuarios WHERE user='$_SESSION[user]'");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Aquí asignamos a $result el array que devuelve, si hay varias lineas tenemos que usar fetchAll.
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
  
        // foreach ($result as $row) {
        //     foreach ($row as $key => $value) {
        //         echo "$key: $value<br>";
        //     }
        // }

        if (!empty($result)) {
            echo "<table id='tablaUsuarios' border='1' cellpadding='5' cellspacing='0'>";
            //echo "<tr><th>Campo</th><th>Valor</th></tr>";
            foreach ($result[0] as $key => $value) {
                echo "<tr>";
                echo "<td><strong>$key</strong></td>";
                echo "<td>$value</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }
    } 
    

    catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
?>