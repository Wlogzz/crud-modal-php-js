<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminaModalLabel">Eliminar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="delete.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-auto">
                            <h5>Está seguro de eliminar el siguiente elemento?</h5>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-recycle"></i> Si, borrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>