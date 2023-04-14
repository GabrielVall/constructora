<?php
include_once("../../../m/SQLConexion.php");
include_once("../../../c/1/fn.php");
$sql = new SQLConexion();

$row_configuraciones = $sql->obtenerResultado("CALL sp_select_configuracion1()");
$total_row_configuraciones = count($row_configuraciones);

$imagenes_nombre = search_files(4,'img', 'inicio','' ,1);
$imagenes_extension = search_files(4,'img', 'inicio', '' ,3);
$imagenes_ruta = search_files(4,'img','inicio', '',4);
$total_imagenes = count($imagenes_ruta);

// arreglo donde almacenaremos las rutas de las imágenes
$imagenes_nombre_archivos = array(); 
$imagenes_extension_archivos = array();
$imagenes_ruta_archivos = array();
$total_imagenes_archivos = array();

foreach($imagenes_nombre as $nombre_imagen){
    $archivos_encontrados = search_files(4,'img','inicio',$nombre_imagen,1);
    $imagenes_nombre_archivos = array_merge($imagenes_nombre_archivos, search_files(4, 'img', 'inicio', $nombre_imagen, 1) ?: ['default.webp']);
    $imagenes_extension_archivos = array_merge($imagenes_extension_archivos, search_files(4,'img','inicio',$nombre_imagen,3) ?: ['webp']);
    $imagenes_ruta_archivos = array_merge($imagenes_ruta_archivos, search_files(4,'img','inicio',$nombre_imagen,4) ?: ['../img/default.webp']);
}

?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Configuraciones agregados</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Configuraciones agregados</h4>
            </div>
            <div class="card-body" id="content_config">
                <div class="nav-tabs-custom text-center">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center active" data-bs-toggle="tab" href="#tab_banner" role="tab" aria-selected="true"><i class="fa-solid fa-list-ul d-block"></i>Banner</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_seccion1" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Seccion 1</a>
                        </li>
                        
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_seccion2" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Seccion 2</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_seccion3" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Seccion 3</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_seccion4" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Seccion 4</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#tab_seccion5" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Seccion 5</a>
                        </li>
                        <li class="nav-item waves-effect waves-ligh">
                            <a class="nav-link text-center" data-bs-toggle="tab" href="#footer" role="tab" aria-selected="false"><i class="fa-solid fa-list-ul d-block"></i>Footer</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-5" id="tab_contenedor">
                    <!-- BANNER -->
                    <div class="tab-pane p-3 active" id="tab_banner" role="tabpanel">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Top</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[0]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[0]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Titulo</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[1]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[1]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Descripcion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[2]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[2]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="mb-1">
                                <div class="text-end mb-3">
                                    <a href="javascript:void(0);" class="ml-auto">
                                        <label for="imagenes_banner" class="text-primary btn btn-sm btn-soft-primary font-bold <?php echo count($imagenes_ruta_archivos[0]) > 0 ? 'disabledevent' : ''; ?>"><i class="fa-solid fa-plus mr-2"></i>Añadir imágenes</label>
                                    </a>
                                    <input type="file" class="d-none" accept="image/png, image/jpeg" id="imagenes_banner">
                                </div>
                                <div class="alert alert-warning alert-dismissible mb-5" role="alert">El formato de imagen es .jpg .jpeg .png y un tamaño mínimo de <span class="fw-bold">1400 x 800 píxeles</span>.</div>
                                <div class="row" id="content_images_banner">
                                <?php
                                    echo
                                    '<div class="col-12 col-md-6 col-lg-4 img-prev-banner" data-id="">
                                        <div class="card border">
                                            <a href="' . $imagenes_ruta_archivos[0] . '" data-fancybox="gallery">
                                                <img class="card-img-top img-fluid bg-light-alt" data-id="1" data-formato="'.$imagenes_extension_archivos[0].'" src="' . $imagenes_ruta_archivos[0] . '">
                                            </a>
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">                      
                                                        <h6 class="card-title">' . $imagenes_nombre_archivos[0] . '</h6>               
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body text-end">
                                                <a href="javascript:void(0);" id="eliminar_img_prev_banner" data-id="" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                                            </div>
                                        </div>
                                    </div>';
                                ?>
                                </div>
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-primary" data-tab="#tab_seccion1">Siguiente</button>
                            </div>
                        </div>
                    </div>
                    <!-- SECCION 1 -->
                    <div class="tab-pane p-3" id="tab_seccion1" role="tabpanel">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Top</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[3]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[3]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Titulo</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[4]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[4]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Descripcion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[5]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[5]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle titulo 1</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[6]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[6]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle descripcion 1</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[7]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[7]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle titulo 2</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[8]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[8]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle descripcion 2</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[9]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[9]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle titulo 3</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[10]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[10]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle descripcion 3</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[11]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[11]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle titulo 4</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[12]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[12]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle descripcion 4</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[13]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[13]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="mb-1">
                                <div class="text-end mb-3">
                                    <a href="javascript:void(0);" class="ml-auto">
                                        <label for="imagenes_seccion_1" class="text-primary btn btn-sm btn-soft-primary font-bold <?php echo count($imagenes_ruta_archivos[1]) > 0 ? 'disabledevent' : ''; ?>"><i class="fa-solid fa-plus mr-2"></i>Añadir imágenes</label>
                                    </a>
                                    <input type="file" class="d-none" accept="image/png, image/jpeg" id="imagenes_seccion_1">
                                </div>
                                <div class="alert alert-warning alert-dismissible mb-5" role="alert">El formato de imagen es .jpg .jpeg .png y un tamaño mínimo de <span class="fw-bold">550 x 680 píxeles</span>.</div>
                                <div class="row" id="content_images_seccion_1">
                                <?php
                                    echo
                                    '<div class="col-12 col-md-6 col-lg-4 img-prev-seccion_1" data-id="">
                                        <div class="card border">
                                            <a href="' . $imagenes_ruta_archivos[1] . '" data-fancybox="gallery">
                                                <img class="card-img-top img-fluid bg-light-alt" data-id="1" data-formato="'.$imagenes_extension_archivos[1].'" src="' . $imagenes_ruta_archivos[1] . '">
                                            </a>
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">                      
                                                        <h6 class="card-title">' . $imagenes_nombre_archivos[1] . '</h6>               
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body text-end">
                                                <a href="javascript:void(0);" id="eliminar_img_prev_seccion_1" data-id="" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                                            </div>
                                        </div>
                                    </div>';
                                ?>
                                </div>
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_banner">Atrás</button>
                                <button class="btn btn-primary" data-tab="#tab_seccion2">Siguiente</button>
                            </div>
                        </div>
                    </div>
                                                    
                    <!-- SECCION 2 -->
                    <div class="tab-pane p-3" id="tab_seccion2" role="tabpanel" data-active-media="0">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Detalle cantidad 1</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[14]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[14]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle texto 1</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[15]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[15]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle cantidad 2</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[16]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[16]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle texto 2</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[17]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[17]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle cantidad 3</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[18]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[18]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle texto 3</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[19]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[19]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle cantidad 4</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[20]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[20]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Detalle texto 4</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[21]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[21]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_seccion1">Atrás</button>
                                <button class="btn btn-primary" data-tab="#tab_seccion3">Siguiente</button>
                            </div>
                        </div>
                    </div>    
                    
                    <!-- SECCION 3 -->
                    <div class="tab-pane p-3" id="tab_seccion3" role="tabpanel" data-active-media="0">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Titulo</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[22]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[22]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Descripcion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[23]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[23]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="mb-1">
                                <div class="text-end mb-3">
                                    <a href="javascript:void(0);" class="ml-auto">
                                        <label for="imagenes_seccion_3" class="text-primary btn btn-sm btn-soft-primary font-bold <?php echo count($imagenes_ruta_archivos[2]) > 0 ? 'disabledevent' : ''; ?>"><i class="fa-solid fa-plus mr-2"></i>Añadir imágenes</label>
                                    </a>
                                    <input type="file" class="d-none" accept="image/png, image/jpeg" id="imagenes_seccion_3">
                                </div>
                                <div class="alert alert-warning alert-dismissible mb-5" role="alert">El formato de imagen es .jpg .jpeg .png y un tamaño mínimo de <span class="fw-bold">700 x 570 píxeles</span>.</div>
                                <div class="row" id="content_images_seccion_3">
                                <?php
                                    echo
                                    '<div class="col-12 col-md-6 col-lg-4 img-prev-seccion_3" data-id="">
                                        <div class="card border">
                                            <a href="' . $imagenes_ruta_archivos[2] . '" data-fancybox="gallery">
                                                <img class="card-img-top img-fluid bg-light-alt" data-id="1" data-formato="'.$imagenes_extension_archivos[2].'" src="' . $imagenes_ruta_archivos[2] . '">
                                            </a>
                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">                      
                                                        <h6 class="card-title">' . $imagenes_nombre_archivos[2] . '</h6>               
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body text-end">
                                                <a href="javascript:void(0);" id="eliminar_img_prev_seccion_3" data-id="" class="btn btn-soft-danger btn-sm"><i class="fa-regular fa-trash-alt me-2"></i>Eliminar</a>
                                            </div>
                                        </div>
                                    </div>';
                                ?>
                                </div>
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_seccion2">Atrás</button>
                                <button class="btn btn-primary" data-tab="#tab_seccion4">Siguiente</button>
                            </div>
                        </div>
                    </div>    

                    <!-- SECCION 4 -->
                    <div class="tab-pane p-3" id="tab_seccion4" role="tabpanel" data-active-media="0">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Titulo</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[24]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[24]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Descripcion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[25]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[25]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_seccion3">Atrás</button>
                                <button class="btn btn-primary" data-tab="#tab_seccion5">Siguiente</button>
                            </div>
                        </div>
                    </div>

                    <!-- SECCION 5 -->
                    <div class="tab-pane p-3" id="tab_seccion5" role="tabpanel" data-active-media="0">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Titulo</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[26]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[26]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Descripcion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[27]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[27]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_seccion4">Atrás</button>
                                <button class="btn btn-primary" data-tab="#footer">Siguiente</button>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="tab-pane p-3" id="footer" role="tabpanel" data-active-media="0">
                        <div id="content_direccion">
                            <div class="mb-5">
                                <label class="control-label fw-bold">Descripcion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[28]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[28]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Direccion</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[29]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[29]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Telefono</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[30]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[30]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Correo</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[31]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[31]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Facebook</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[32]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[32]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Twitter</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[33]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[33]['descripcion_configuracion']; ?>">
                                <label class="control-label fw-bold">Youtube</label>
                                <input id="direccion" type="text" class="form-control mb-3" data-id="<?php echo $row_configuraciones[34]['id_configuracion']; ?>" value="<?php echo $row_configuraciones[34]['descripcion_configuracion']; ?>">
                            </div>
                            <div class="text-end mt-5 pt-5 border-top">
                                <button class="btn btn-outline-primary" data-tab="#tab_seccion5">Atrás</button>
                                <button class="btn btn-primary" id="btn_guardar_config">Guardar Cambios</button>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODALES -->
<!-- IMG BANNER -->
<div class="modal fade" id="modal_img_banner" data-bs-backdrop="static"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-falcon-primary" id="btn_add_img_banner" type="button">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- IMG SECCION 1 -->
<div class="modal fade" id="modal_img_seccion_1" data-bs-backdrop="static"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-falcon-primary" id="btn_add_img_seccion_1" type="button">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- IMG SECCION 3 -->
<div class="modal fade" id="modal_img_seccion_3" data-bs-backdrop="static"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-falcon-primary" id="btn_add_img_seccion_3" type="button">Confirm</button>
            </div>
        </div>
    </div>
</div>