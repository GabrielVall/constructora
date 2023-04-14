<?php
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_propiedades = $sql->obtenerResultado("CALL sp_select_propiedades1()");
$total_row_propiedades = count($row_propiedades);
//  phpinfo();
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
                    <table class="table table-striped mb-0" id="tbl_propiedades">
                        <thead>
                            <tr>
                                <th>Dirección</th>
                                <th class="text-nowrap text-center">Tipo de propiedad</th>
                                <th class="text-nowrap text-center">Tipo de venta</th>
                                <th class="text-nowrap text-center">Mts²</th>
                                <th class="text-nowrap text-end">Precio</th>
                                <th class="text-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $total_row_propiedades; $i++) {
                                $src_img = search_files(4, 'img', 'propiedades', $row_propiedades[$i]['id_propiedad'], 4);
                                echo
                                '<tr id="tr_propiedades_'.$row_propiedades[$i]['id_propiedad'].'">
                                    <td class="text-truncate" style="max-width: 200px;">
                                        <a href="' . $src_img[0] . '" data-fancybox="gallery">
                                            <img src="' . $src_img[0] . '" alt="' . $src_img[0] . '" class="rounded-circle thumb-xs me-1"> ' .      $row_propiedades[$i]['direccion_propiedad'] . '
                                        </a>
                                    </td>
                                    <td class="text-nowrap text-center">' . $row_propiedades[$i]['nombre_tipo_propiedad'] . '</td>
                                    <td class="text-nowrap text-center">' . $row_propiedades[$i]['nombre_tipo_venta'] . '</td>
                                    <td class="text-nowrap text-center">' . $row_propiedades[$i]['mts_propiedad'] . '</td>
                                    <td class="text-nowrap text-end">$' . $row_propiedades[$i]['precio_propiedad'] . '</td>
                                    <td class="text-end">
                                        <div class="btn-group dropstart">                                        
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-chevron-left"></i> Opciones</button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="#propiedad_' . $row_propiedades[$i]['id_propiedad'] . '">Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger fw-semibold" href="javascript:void(0);" data-table="tbl_propiedades" data-type="delete" data-id="' . $row_propiedades[$i]['id_propiedad'] . '">Eliminar</a>
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
                <p>Estás apunto de eliminar esta propiedad, una vez eliminada la propiedad, no podrás recuperarla ¿Estás seguro de eliminarla? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm delete" id="btn_eliminar_propiedad">Si, eliminar</button>
            </div>
        </div>
    </div>
</div>
<script>
    // DATATABLE
    var tbl_propiedades = $('#tbl_propiedades').DataTable(fn_config_datatable_1(true, true, 0, 1));
</script>