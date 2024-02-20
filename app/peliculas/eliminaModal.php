<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">   
                <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>¿Está seguro de eliminar este registro?</p>

                <div class="modal-footer">
                    <form action="elimina.php" method="post">
                        <input type="hidden" name="id" id="id">
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Cancelar</button>
                            <button type="submit" class="btn btn-danger"><i class="bi bi-archive"></i> Eliminar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
