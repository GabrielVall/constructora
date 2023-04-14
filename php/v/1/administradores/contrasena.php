<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Administradores</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nueva contraseña</h4>
            </div>
            <div class="card-body" id="content_info">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label fw-bold">Nueva contraseña</label>
                                    <input type="password" class="form-control" id="contrasena">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" id="btn_contrasena_administrador" data-id="<?php echo $_POST['id_administrador']; ?>">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>