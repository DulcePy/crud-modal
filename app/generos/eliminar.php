<?php

    session_start();
    require '../config/database.php';

    $id = $conn->real_escape_string($_POST["id"]);

    $sql = "DELETE FROM genero WHERE id=$id";
    
    if($conn->query($sql)){
        $_SESSION['color'] = "success";
        $_SESSION['msg'] .= "¡El registro se eliminó exitosamente!";
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al intentar eliminar el registro";
    }

    header('Location: indexGenero.php');

?>