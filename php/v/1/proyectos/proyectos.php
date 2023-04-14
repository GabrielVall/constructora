<?php 
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_proyectos = $sql->obtenerResultado("CALL sp_select_proyectos1()");
$total_row_proyectos = count($row_proyectos);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Proyectos</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Proyectos agregados</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="text-end">
                    </div>
                    <table class="table table-striped mb-0" id="tbl_proyectos">
                        <thead>
                            <tr>
                                <th>Direccion</th>
                                <th class="text-nowrap">Descripcion</th>
                                <th class="text-nowrap">Tipo de propiedad</th>
                                
                                <th class="text-nowrap">Mts²</th>
                                <th class="text-nowrap">Precio</th>
                                <th class="text-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $total_row_proyectos; $i++) {
                                $src_img = search_files(4, 'img', 'proyectos', $row_propiedades[$i]['id_propiedad'], 4);
                                echo
                                '<tr id="tr_propiedades_'.$row_proyectos[$i]['id_proyecto'].'">
                                    
                                    <td class="text-nowrap">' . $row_proyectos[$i]['direccion_proyecto'] . '</td>
                                    <td class="text-nowrap">' . $row_proyectos[$i]['descripcion_proyecto'] . '</td>
                                    <td class="text-nowrap text-center">' . $row_proyectos[$i]['nombre_tipo_propiedad'] . '</td>
                                    
                                    <td class="text-nowrap text-center">' . $row_proyectos[$i]['mts_proyecto'] . '</td>
                                    <td class="text-nowrap text-end">$' . $row_proyectos[$i]['precio_proyecto'] . '</td>
                                    <td class="text-end">
                                        <div class="btn-group dropstart">                                        
                                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-chevron-left"></i> Opciones</button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="#proyecto_' . $row_proyectos[$i]['id_proyecto'] . '">Editar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger fw-semibold" href="javascript:void(0);" data-table="tbl_propiedades" data-type="delete" data-id="' . $row_proyectos[$i]['id_proyecto'] . '">Eliminar</a>
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
                <p>Estás apunto de eliminar este proyecto, una vez eliminado el proyecto, no podrás recuperarlo ¿Estás seguro de eliminarlo? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm delete" id="btn_eliminar_proyecto">Si, eliminar</button>
            </div>
        </div>
    </div>
</div>
<script>
    // DATATABLE
    var tbl_proyectos = $('#tbl_proyectos').DataTable(fn_config_datatable_1(true, true, 0, 1));
</script>