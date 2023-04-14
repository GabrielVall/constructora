<?php
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_administradores = $sql->obtenerResultado("CALL sp_select_administradores1()");
$total_row_administradores = count($row_administradores);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Administradores agregados</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Administradores agregados</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" id="tbl_administradores">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Nombre</th>
                                <th class="whitespace-nowrap">Apellido</th>
                                <th class="whitespace-nowrap">Correo</th>
                                <th class="whitespace-nowrap">Teléfono</th>
                                <th class="whitespace-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $total_row_administradores; $i++) {
                                echo
                                '<tr id="tr_administradores_'.$row_administradores[$i]['id_administrador'].'">
                                    <td class="whitespace-nowrap">' . $row_administradores[$i]['nombre_administrador'] . '</td>
                                    <td class="whitespace-nowrap">' . $row_administradores[$i]['apellido_administrador'] . '</td>
                                    <td class="whitespace-nowrap">' . $row_administradores[$i]['correo_usuario'] . '</td>
                                    <td class="whitespace-nowrap">' . $row_administradores[$i]['telefono_usuario'] . '</td>
                                    <td class="text-end">
                                        <div class="btn-group dropstart">                                        
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-chevron-left"></i> Opciones</button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="#administrador_' . $row_administradores[$i]['id_administrador'] . '">Editar</a>
                                                <a class="dropdown-item" href="#pass_administrador_' . $row_administradores[$i]['id_administrador'] . '">Cambiar contraseña</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger fw-semibold" href="javascript:void(0);" data-table="tbl_administradores" data-type="delete" data-id="' . $row_administradores[$i]['id_administrador'] . '">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>';
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
<div class="modal fade" id="modal-delete" tabindex="-1"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">¿Estás seguro?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Estás apunto de eliminar a un administrador, una vez eliminado el administrador, no podrás recuperar su información ¿Estás seguro de eliminarlo? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm delete" id="btn_eliminar_administrador">Si, eliminar</button>
            </div>
        </div>
    </div>
</div>
<script>
    // DATATABLE
    var tbl_administradores = $('#tbl_administradores').DataTable(fn_config_datatable_1(true, true, 0, 1));
</script>