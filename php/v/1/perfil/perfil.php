<?php 
session_start();
include_once("../../../m/SQLConexion.php");
$sql = new SQLConexion();

$row_correo = $sql->obtenerResultado("SELECT fn_select_correo1('".$_SESSION['id_usuario_constructora']."')");

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Perfil</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Configuracion de cuenta</h4>
            </div>
            <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title" id="card_title">Actualizar correo electrónico</h4>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="correo_cuenta" value="<?php echo $row_correo[0][0]; ?>">
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-end">
                        <button class="btn btn-primary" id="btn_guardar_correo_cuenta">Guardar cambios</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title" id="card_title">Actualizar contraseña</h4>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Escriba la nueva contraseña</label>
                            <input type="password" class="form-control" id="pass_cuenta">
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-end">
                        <button class="btn btn-primary" id="btn_guardar_contrasena_cuenta">Guardar cambios</button>
                    </div>
                </div>
        </div>
    </div>
</div>