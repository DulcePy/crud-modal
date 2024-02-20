<!-- Modal -->
<div class="modal fade" id="generoModal" tabindex="-1" aria-labelledby="generoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">   
                <h1 class="modal-title fs-5" id="generoModalLabel">Agregar género</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form action="guardarGenero.php" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>

                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-bookmark-check"></i> Guardar</button>
                    </div>
                </form>
                
            </div>

        </div>
    </div>
</div>
