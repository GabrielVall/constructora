<?php 
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_propiedades = $sql->obtenerResultado("CALL sp_select_tipo_propiedad()");
$total_row_propiedades = count($row_propiedades);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Propiedades agregadas</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Propiedades agregadas</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="text-end">
                        <button class="btn btn-primary btn-dark" data-bs-toggle="modal" data-bs-target="#modal-add">Agregar</button>
                    </div>
                    <table class="table table-striped mb-0" id="tbl_tipos_propiedad">
                        <thead>
                            <tr>
                                <th>Tipo de propiedad</th>
                                <th class="text-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            for ($i = 0;$i < $total_row_propiedades;$i++){
                                echo
                                '
                                <tr id="tr_tipos_propiedad_'.$row_propiedades[$i]['id_tipo_propiedad'].'">
                                    <td class="whitespace-nowrap">' . $row_propiedades[$i]['nombre_tipo_propiedad'] . '</td>
                                    <td class="text-end">
                                        <div class="btn-group dropstart">                                        
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-chevron-left"></i> Opciones</button>
                                            <div class="dropdown-menu" style="">
                                                <a href="javascript:void(0);" class="dropdown-item" data-table="tbl_tipos_propiedad" data-type="update" data-id="'.$row_propiedades[$i]['id_tipo_propiedad'].'">Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger fw-semibold" href="javascript:void(0);" data-table="tbl_propiedades" data-type="delete" data-id="' . $row_propiedades[$i]['id_tipo_propiedad'] . '">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                ';
                            }
                            ?>
                        </tbody>
                    </table>
                    <!--end /table-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODALES -->
<!-- AGREGAR -->
<div class="modal fade" id="modal-add" tabindex="-1"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Nueva propiedad</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="content_info_add">
                <div class="form-group">
                    <label class="form-label">Tipo de propiedad</label>
                    <input type="text" id="nombre_tipo" class="form-control format-string" maxlength="20">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn_agregar_tipo_propiedad">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- EDITAR -->
<div class="modal fade" id="modal-update" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollinglongcontentLabel">Editar tipo de propiedad</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="content_info_update">
                <div class="form-group">
                    <label class="form-label">Tipo de propiedad</label>
                    <input type="text" id="nombre_tipo_propiedad_edit" maxlength="20" class="form-control format-string child">
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary edit" id="btn_guardar_tipo_propiedad" ><i class="bx bxs-save align-middle me-1"></i>Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
<!-- ELIMINAR -->
<div class="modal fade" id="modal-delete" tabindex="-1"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">¿Estás seguro?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Estás apunto de eliminar este tipo de propiedad, una vez eliminado, no podrás recuperarlo ¿Estás seguro de eliminarlo? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm delete" id="btn_eliminar_tipo_propiedad">Si, eliminar</button>
            </div>
        </div>
    </div>
</div>
<script>
    // DATATABLE
    var tbl_tipos_propiedad = $('#tbl_tipos_propiedad').DataTable(fn_config_datatable_1(true, true, 0, 1));
</script>