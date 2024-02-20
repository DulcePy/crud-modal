<?php

    require '../config/database.php';

    $id = $conn->real_escape_string($_POST["id"]);
    // obtener los datos para editar
    $sql = "SELECT id, nombre, descripcion, id_genero FROM pelicula WHERE id = $id LIMIT 1";
    $resultado = $conn->query($sql);
    $row = $resultado->num_rows; // nos permite saber si la consulta contiene alguna fila

    $pelicula = [];

    if($row > 0) {
        $pelicula = $resultado->fetch_array();
    }

    echo json_encode($pelicula, JSON_UNESCAPED_UNICODE);
?>