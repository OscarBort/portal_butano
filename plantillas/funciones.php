<?php

function inicioSesion(){
    session_start();
    //session_regenerate_id(true);

    if (!isset($_SESSION["rol"]))
       $_SESSION["rol"] = "invitado";

    var_dump($_SESSION);
}

    function login($usuario, $password){
        if (!isset($_SESSION["rol"]))
        session_start();
        if ($_SESSION['rol'] == "invitado")
                $_SESSION['origen'] = $_SERVER["PHP_SELF"];

                if ($usuario == "" && $password == "") {
                    $_SESSION['mensaje'] = "No has introducido ningún dato.";
                    header("Location:" . $_SESSION['origen']);
                    unset($_SESSION['origen']);
                    die;
                }

            // comprobamos que el usuario no está vacío antes de empezar para que no de error y abrimos la base de datos.
            if ($usuario != ""){
                try {
                    $conn = new PDO("mysql:host=localhost;dbname=primerejemplo", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT user, password, rol FROM usuarios WHERE user='$usuario'");
                    $stmt->execute();
                  
                    // Comprobamos si el retorno de la base de datos es true o false
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    // Aquí asignamos a $result el array que devuelve, si hay varias lineas tenemos que usar fetchAll.
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result != ""){
                    if (password_verify($password, $result["password"])){
                        // una vez hemos comparado la contraseña, con el siguiente código actualizamos la hora de acceso
                        $sql = "UPDATE usuarios SET facceso = NOW() WHERE user = '$usuario'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        // Esto es para pintarme en index los session de control
                        $_SESSION["rol"] = $result["rol"];
                        $_SESSION["user"] = $result["user"];
                        if ($_SESSION["rol"] == "administrador")
                            header("Location:" . $_SESSION['origen']);
                        else header("Location: index.php");
                        unset($_SESSION['origen']);
                        die();
                    //}
                    }
                    else {$_SESSION['mensaje'] = "Error iniciar sesión(contraseña)";
                    }
                }
                else {
                    $_SESSION['mensaje'] = "Error iniciar sesión(usuario)";
                }
                }
                // el catch es si el try del inicio de sesión no funciona
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                // cerramos la base de datos al acabar
                $conn = null;
            }
            // elseif ($usuario != "admin" && $usuario != ""){
            //     /*echo "El usuario es incorrecto.";*/
            //     $_SESSION['mensaje'] = "El usuario es incorrecto.";
            //     header("Location:" . $_SESSION['origen']);
            //     unset($_SESSION['origen']);
            // } 
            // elseif ($_POST["password"] != "1234" && $password != ""){
            //     $_SESSION['mensaje'] = "La contraseña es incorrecta.";
            //     header("Location:" . $_SESSION['origen']);
            //     unset($_SESSION['origen']);
            // }
    }

      function logout(){
        session_start();
        session_unset();
        session_destroy();
        header ('Location: '.$_SERVER['PHP_SELF']);
        die();
    }
    if (isset($_GET['salir'])) logout();

function sanear($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>