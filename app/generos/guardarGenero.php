<?php

    session_start();
    require '../config/database.php';

    $nombreGenero = $conn->real_escape_string($_POST["nombre"]);

    // consulta para verificar si es que existe en la base de datos
    $consulta = "SELECT * FROM genero WHERE nombre = '$nombreGenero'";
    $result = $conn->query($consulta);
    $row = $result->fetch_assoc();

    if($row > 0){    // si existe
        $_SESSION['color'] = "warning";
        $_SESSION['msg'] = "El género ya existe en la base de datos";

    } else {
        $sql = "INSERT INTO genero(nombre) VALUES ('$nombreGenero')";
        if($conn->query($sql)){
            $id = $conn->insert_id;

            $_SESSION['color'] = "success";
            $_SESSION['msg'] = "¡Nuevo género registrado exitosamente!";

        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] = "Error al intentar guardar género";
        }
    }

    header('Location: indexGenero.php');

?>