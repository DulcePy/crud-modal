<?php 
    session_start();
    require '../config/database.php'; 

    $sqlPeliculas = "SELECT p.id, p.nombre, p.descripcion, g.nombre AS genero FROM pelicula AS p INNER JOIN genero AS g ON p.id_genero = g.id";
    $peliculas = $conn->query($sqlPeliculas);

    $dir = "posters/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Modal</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container py-3">
        <h2 class="text-center"><i class="bi bi-camera-reels-fill"></i> Películas <i class="bi bi-camera-reels-fill"></i></h2>
        <hr>
        <!-- MENSAJES DE ALERTA  --->
        <?php if(isset($_SESSION['msg']) && isset($_SESSION['color'])){ ?>

            <div class="alert alert-<?php echo $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['msg']; // se imprimen los mensajes ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php 
        unset($_SESSION['msg']);    // eliminar la variable, para que no aparezca a cada rato
        unset($_SESSION['color']);    // eliminar la variable, para que no aparezca a cada rato
        } ?>

        <!--div class="row justify-content-end" center--->
            <div class="col-auto">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="bi bi-file-plus"></i> Registrar película</a>
                <a href="../generos/indexGenero.php" class="btn btn-success"><i class="bi bi-diagram-3-fill"></i> Géneros</a>
            </div>
        <!--/div--->

        <table class="table table-sm table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Género</th>
                    <th>Poster</th>
                    <th><i class="bi bi-gear"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row_pelicula = $peliculas->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $row_pelicula['id']; ?></td>
                        <td><?php echo $row_pelicula['nombre']; ?></td>
                        <td><?php echo $row_pelicula['descripcion']; ?></td>
                        <td><?php echo $row_pelicula['genero']; ?></td>
                        <td><img src="<?php echo $dir . $row_pelicula['id'] . '.jpg?n=' . time(); ?>" width="100px" alt="Imágen"></td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editaModal" class="btn btn-sm btn-warning" data-bs-id="<?php echo $row_pelicula['id']; ?>"><i class="bi bi-pencil"></i> Editar</a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?php echo $row_pelicula['id']; ?>"><i class="bi bi-archive"></i> Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <?php
        $sqlGenero = "SELECT id, nombre FROM genero";
        $generos = $conn->query($sqlGenero);
        
        include 'nuevoModal.php';
        $generos->data_seek(0);
        include 'editarModal.php';
        include 'eliminaModal.php'; 
    ?>

    <script>
        let nuevoModal = document.getElementById('nuevoModal')
        let editaModal = document.getElementById('editaModal')
        let eliminaModal = document.getElementById('eliminaModal')

        nuevoModal.addEventListener('shown.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').focus()
        })

        // LIMPIAR CAMPOS DE TEXTO
        nuevoModal.addEventListener('hide.bs.modal', event => {
            nuevoModal.querySelector('.modal-body #nombre').value = ""
            nuevoModal.querySelector('.modal-body #descripcion').value = ""
            nuevoModal.querySelector('.modal-body #genero').value = ""
            nuevoModal.querySelector('.modal-body #poster').value = ""
        })
        editaModal.addEventListener('hide.bs.modal', event => {
            editaModal.querySelector('.modal-body #nombre').value = ""
            editaModal.querySelector('.modal-body #descripcion').value = ""
            editaModal.querySelector('.modal-body #genero').value = ""
            editaModal.querySelector('.modal-body #poster').value = ""
            editaModal.querySelector('.modal-body #img_poster').value = ""
        })

        // EDITAR UNA PELICULA
        editaModal.addEventListener('show.bs.modal', event => {
            // detectar qué boton se presiono
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            let inputId = editaModal.querySelector('.modal-body #id')
            let inputNombre = editaModal.querySelector('.modal-body #nombre')
            let inputDescripcion = editaModal.querySelector('.modal-body #descripcion')
            let inputGenero = editaModal.querySelector('.modal-body #genero')
            let poster = editaModal.querySelector('.modal-body #img_poster')

            let url = "getPelicula.php"         // ruta para hacer la peticion de editar
            let formData = new FormData()
            formData.append('id', id)

            fetch(url, {
                method: "POST",
                body: formData
            }).then(response => response.json())
            .then(data => {
                inputId.value = data.id
                inputNombre.value = data.nombre
                inputDescripcion.value = data.descripcion
                inputGenero.value = data.id_genero
                poster.src = '<?= $dir ?>' + data.id + '.jpg'
            }).catch(err => console.log(err))
        })

        // ELIMINAR UNA PELICULA
        eliminaModal.addEventListener('show.bs.modal', event => {
            // detectar qué boton se presiono
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')

            eliminaModal.querySelector('.modal-footer #id').value = id
        })

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>