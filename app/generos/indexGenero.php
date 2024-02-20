<?php 
    session_start();
    require '../config/database.php'; 
    $sqlgeneros = "SELECT * FROM genero";
    $result = $conn->query($sqlgeneros);
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD Géneros</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>

    <body>
        <div class="container py-3">
            <h2 class="text-center"><i class="bi bi-diagram-3-fill"></i> Géneros <i class="bi bi-diagram-3-fill"></i>
            </h2>
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

            <div class="col-auto">
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generoModal"><i class="bi bi-file-plus"></i> Registrar género</a>
                <a href="../peliculas/index.php" class="btn btn-success"><i class="bi bi-camera-reels-fill"></i> Películas</a>
            </div>

            <table class="table table-sm table-striped table-hover mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th><i class="bi bi-gear"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row_generos = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $row_generos['id']; ?></td>
                        <td><?php echo $row_generos['nombre']; ?></td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editarGeneroModal" class="btn btn-sm btn-warning" data-bs-id="<?php echo $row_generos['id']; ?>"><i class="bi bi-pencil"></i> Editar</a>
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarGeneroModal" data-bs-id="<?php echo $row_generos['id']; ?>"><i class="bi bi-archive"></i> Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>



        <?php
            include 'generoModal.php';
            include 'eliminarGeneroModal.php';
        ?>
        <script>
            let generoModal = document.getElementById('generoModal')
            let eliminarModal = document.getElementById('eliminarGeneroModal')

            // GENERO 
            generoModal.addEventListener('shown.bs.modal', event => {
                generoModal.querySelector('.modal-body #nombre').focus()
            })

            generoModal.addEventListener('hide.bs.modal', event => {
                generoModal.querySelector('.modal-body #nombre').value = ""
            })

            // ELIMINAR 
            eliminarModal.addEventListener('show.bs.modal', event => {
                let button = event.relatedTarget            // detectar qué boton se presiono
                let id = button.getAttribute('data-bs-id')
                eliminarModal.querySelector('.modal-footer #id').value = id
            })
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>

</html>