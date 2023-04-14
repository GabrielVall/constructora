<?php 
session_start();
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_configuracion = $sql->obtenerResultado("CALL sp_select_configuracion2('".$_POST['id_configuracion']."')");

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Configuraciones</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Editar configuracion</h4>
            </div>
            <div class="card-body" id="content_info">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Titulo</label>
                                    <input type="text" class="form-control" id="Titulo" value="<?php echo $row_configuracion[0]['nombre_configuracion'] ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group mt-3">
                                    <label class="control-label fw-bold">Descripcion</label>
                                    <textarea rows="7" type="text" class="form-control" id="Descripcion"><?php echo $row_configuracion[0]['descripcion_configuracion'] ?></textarea>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="text-end mt-5 pt-5 border-top">
                    <button class="btn btn-primary" id="btn_guardar_configuracion" data-id="<?php echo $_POST['id_configuracion'] ?>">Guardar configuracion</button>
                </div>
            </div>
        </div>
    </div>
</div>