<?php

    session_start();
    require '../config/database.php';

    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $descripcion = $conn->real_escape_string($_POST["descripcion"]);
    $genero = $conn->real_escape_string($_POST["genero"]);

    // consulta para verificar si es que existe en la base de datos
    $consulta = "SELECT * FROM pelicula WHERE nombre = '$nombre'";
    $result = $conn->query($consulta);
    $row = $result->fetch_assoc();

    if($row > 0){    // si existe
        $_SESSION['color'] = "warning";
        $_SESSION['msg'] = "La película ya existe en la base de datos";

    } else {
        $sql = "INSERT INTO pelicula(nombre, descripcion, id_genero, fecha_alta) VALUES ('$nombre', '$descripcion', $genero, NOW())";
        
        if($conn->query($sql)){
            $id = $conn->insert_id;

            $_SESSION['color'] = "success";
            $_SESSION['msg'] .= "¡Registro exitoso!";

            if($_FILES['poster']['error'] == UPLOAD_ERR_OK) {
                $permitidos = array("image/jpg", "image/jpeg");

                if(in_array($_FILES['poster']['type'], $permitidos)){
                    $dir = "posters";
                    $info_img = pathinfo($_FILES['poster']['name']);
                    $info_img['extension'];

                    $poster = $dir . '/' . $id . '.jpg';
                    // si no existe la carpeta, creala
                    if(!file_exists($dir)){
                        mkdir($dir, 0777);
                    }

                    if(!move_uploaded_file($_FILES['poster']['tmp_name'], $poster)){
                        $_SESSION['color'] = "danger";
                        $_SESSION['msg'] .= "<br>Error al guardar la imagen";
                    }

                } else {
                    $_SESSION['color'] = "warning";
                    $_SESSION['msg'] .= "<br>El formato de la imagen no está permitido";
                }
            }
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] = "Error al intentar guardar";
        }
    }

    header('Location: index.php');

?>