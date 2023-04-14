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
                <h4 class="card-title">Nuevo administrador</h4>
            </div>
            <div class="card-body" id="content_info">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label fw-bold">Nombre(s)</label>
                                    <input type="text" class="form-control format-string" id="nombre">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mt-3 mt-md-0">
                                    <label class="control-label fw-bold">Apellido</label>
                                    <input type="text" class="form-control format-string" id="apellido">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Correo electrónico</label>
                                    <input class="form-control input-mask" data-inputmask="'alias' : 'email'" id="correo">
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Teléfono</label>
                                    <input type="text" class="form-control format-number input-mask" data-inputmask="'mask': '(999) 999-9999'" id="telefono">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mt-3 mb-3">
                                    <label class="control-label fw-bold">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" id="btn_agregar_administrador">Agregar administrador</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // MASK
    $(".input-mask").inputmask();
</script>